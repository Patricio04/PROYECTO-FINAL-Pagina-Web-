<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';


// Verificar si hay un ID de manga en la URL
$id_manga = isset($_GET['id_manga']) ? intval($_GET['id_manga']) : 0;

if ($id_manga > 0) {
    // Cargar los datos del manga y sus etiquetas
    $sql = "SELECT m.IdManga, m.Titulo, m.Portada, m.Descripcion, m.Visualizaciones, 
               GROUP_CONCAT(DISTINCT e.NombreEtiqueta) AS Etiquetas,
               c.IdCapitulo, c.NombreCapitulo
        FROM Manga m
        LEFT JOIN EtiquetaManga em ON m.IdManga = em.IdManga
        LEFT JOIN Etiqueta e ON em.IdEtiqueta = e.IdEtiqueta
        LEFT JOIN Capitulo c ON m.IdManga = c.IdManga
        WHERE m.IdManga = ?
        GROUP BY m.IdManga";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_manga);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el manga
    if ($result->num_rows > 0) {
        // Obtener los datos del manga y sus etiquetas
        $manga = $result->fetch_assoc();
        $manga['etiquetas'] = $manga['Etiquetas'] ? explode(',', $manga['Etiquetas']) : array();

        // Obtener los capítulos del manga en orden descendente
        $sql_capitulos = "SELECT IdCapitulo, NombreCapitulo 
                          FROM Capitulo 
                          WHERE IdManga = ? 
                          ORDER BY Orden ASC";
        $stmt_capitulos = $conn->prepare($sql_capitulos);
        $stmt_capitulos->bind_param("i", $id_manga);
        $stmt_capitulos->execute();
        $result_capitulos = $stmt_capitulos->get_result();

        // Almacenar los capítulos en el arreglo del manga
        $manga['capitulos'] = array();
        while ($capitulo = $result_capitulos->fetch_assoc()) {
            $manga['capitulos'][] = $capitulo;
        }
    } else {
        // No se encontró el manga
        echo "No se encontró el manga con el ID proporcionado.";
        exit(); // Salir del script
    }

    // Cerrar las conexiones
    $stmt->close();
    $stmt_capitulos->close();
} else {
    echo "ID del manga no válido.";
    exit(); // Salir del script
}

?>
<style>
    .card-img-top {
        max-width: 200px;
        object-fit: cover;
        margin: 0 auto;
        height: auto;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .badge-info {
        background-color: #17a2b8;
        color: white;
    }

    .list-group-item {
        font-size: 1rem;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary:hover {
        color: white;
        background-color: #007bff;
        border-color: #007bff;
    }

    /* Estilos para el contenedor de la tarjeta */
    .card-container {
        width: 1300px;
        background: linear-gradient(135deg, #6f42c1, #933c8d);
        padding: 20px;
        text-align: center;
        margin-bottom: 30px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5);
    }

    .card {
        width: 100%;
        padding: 20px;
    }

    .hr-separator {
        border: 1px solid #dee2e6;
        margin: 20px 0;
    }

    .card-neon {
        background-color: #6f42c1;
        box-shadow: 0 0 20px #6f42c1;
    }

    .comments-section {
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 15px;
        display: none;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5);
    }

    .comment {
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5);
    }

    .comment-author {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .comment-content {
        margin-bottom: 5px;
    }

    .comment-date {
        font-size: 0.8rem;
        color: #6c757d;
        /* Color de texto gris */
    }

    .show-comments-btn {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #6f42c1;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
   

    
    .list-group-item {
        transition: filter 0.3s ease;
        /* Añadir una transición suave */
    }

    .list-group-item:hover {
        filter: brightness(1.3);
        /* Aumentar el brillo al pasar el ratón */
    }

</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card-container"> <!-- Contenedor de la tarjeta -->
                <div class="card shadow-sm d-flex flex-row card-neon">
                    <img src="<?php echo $manga['Portada']; ?>" class="card-img-top" alt="Imagen de manga">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title"><?php echo $manga['Titulo']; ?></h5>
                        <p class="card-text"><?php echo $manga['Descripcion']; ?></p>
                        <div>
                            <?php foreach ($manga['etiquetas'] as $etiqueta) : ?>
                                <span class="badge badge-pill badge-info"><?php echo $etiqueta; ?></span>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="hr-separator">
    <!-- Apartado para los capítulos -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-3 text-white">Capítulos</h3>
            <ul class="list-group">
                <?php foreach ($manga['capitulos'] as $capitulo) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                        <?php echo $capitulo['NombreCapitulo']; ?>

                        <a href="#" class="btn btn-sm btn-outline-secondary">Leer</a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .comments-section-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .comments-section {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .comments-section h2 {
            color: #6f42c1;
            text-align: center;
            margin-bottom: 20px;
        }
        .comment {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .comment-author {
            font-weight: bold;
        }
        .comment-content {
            margin-top: 5px;
        }
        .comment-date {
            font-size: 0.9em;
            color: #777;
        }
        #commentForm {
            margin-bottom: 20px;
        }
        #commentForm label {
            display: block;
            margin-top: 10px;
        }
        #commentForm input, #commentForm textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        #commentForm button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #6f42c1;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        #commentForm button:hover {
            background-color: #5a379c;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            cursor: pointer;
        }
        .user-info span {
            font-weight: bold;
            font-size: 1.2em;
        }
        .show-comments-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #6f42c1;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .show-comments-btn:hover {
            background-color: #5a379c;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 350px;
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 400px;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .avatar-option {
            display: inline-block;
            margin: 10px;
            cursor: pointer;
        }
        .avatar-option img {
            border-radius: 50%;
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>

<button class="show-comments-btn" onclick="toggleComments()">Mostrar comentarios</button>

<div class="comments-section-container">
    <div class="comments-section" id="commentsSection" style="display:none;">
        <div class="user-info">
            <img src="avatar1.png" alt="Avatar" id="userAvatar" onclick="openModal()">
            <span id="userName">Nombre del Usuario</span>
        </div>
        <h2>Comentarios</h2>
        
        <!-- Formulario para agregar nuevos comentarios -->
        <h3 style="color: #6f42c1;">Añadir un comentario</h3>
        <form id="commentForm" onsubmit="addComment(event)">
            <!-- El campo de nombre se oculta ya que viene de la base de datos -->
            <input type="hidden" id="author" name="author" value="Nombre del Usuario">
            <label for="content">Comentario:</label>
            <textarea id="content" name="content" required></textarea>
            <button type="submit">Enviar</button>
        </form>

        <div id="commentsContainer">
            <div class="comment">
                <div class="comment-author">Usuario 1</div>
                <div class="comment-content">¡Me encantó este capítulo!</div>
                <div class="comment-date">Publicado el 10 de mayo de 2024</div>
            </div>
            <div class="comment">
                <div class="comment-author">Usuario 2</div>
                <div class="comment-content">Prueba comentarios xdd xd xd</div>
                <div class="comment-date">Publicado el 11 de mayo de 2024</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar avatar -->
<div id="avatarModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Selecciona tu avatar</h2>
        <div class="avatar-option" onclick="selectAvatar('avatar4.jpg')">
            <img src="avatar1.png" alt="Avatar 1">
        </div>
        <div class="avatar-option" onclick="selectAvatar('avatar1.jpeg')">
            <img src="avatar2.png" alt="Avatar 2">
        </div>
        <div class="avatar-option" onclick="selectAvatar('avatar3.png')">
            <img src="avatar3.png" alt="Avatar 3">
        </div>
        <div class="avatar-option" onclick="selectAvatar('avatar4.png')">
            <img src="avatar4.png" alt="Avatar 4">
        </div>
    </div>
</div>

<script>


// Para base de datos funcionalidad 
const loggedInUser = "Nombre del Usuario"; // Este valor vendría de la base de datos
document.getElementById('author').value = loggedInUser;
document.getElementById('userName').textContent = loggedInUser;

function toggleComments() {
    const commentsSection = document.getElementById('commentsSection');
    const btn = document.querySelector('.show-comments-btn');
    if (commentsSection.style.display === 'none') {
        commentsSection.style.display = 'block';
        btn.textContent = 'Ocultar comentarios';
    } else {
        commentsSection.style.display = 'none';
        btn.textContent = 'Mostrar comentarios';
    }
}

function addComment(event) {
    event.preventDefault();

    const author = loggedInUser;
    const content = document.getElementById('content').value;
    const date = new Date().toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const commentSection = document.getElementById('commentsContainer');

    const newComment = document.createElement('div');
    newComment.classList.add('comment');

    const newCommentAuthor = document.createElement('div');
    newCommentAuthor.classList.add('comment-author');
    newCommentAuthor.textContent = author;

    const newCommentContent = document.createElement('div');
    newCommentContent.classList.add('comment-content');
    newCommentContent.textContent = content;

    const newCommentDate = document.createElement('div');
    newCommentDate.classList.add('comment-date');
    newCommentDate.textContent = `Publicado el ${date}`;

    newComment.appendChild(newCommentAuthor);
    newComment.appendChild(newCommentContent);
    newComment.appendChild(newCommentDate);

    commentSection.appendChild(newComment);

    // Clear the form
    document.getElementById('commentForm').reset();
}

function openModal() {
    document.getElementById('avatarModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('avatarModal').style.display = 'none';
}

function selectAvatar(avatarSrc) {
    document.getElementById('userAvatar').src = avatarSrc;
    closeModal();
}
</script>
<?php
// Incluye el footer
include '../Plantillas/Footer.php';



?>