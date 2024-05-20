<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';

date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, 'es_ES.UTF-8');
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


    $stmt_capitulos->close();
} else {
    echo "ID del manga no válido.";
    exit(); // Salir del script
}

// Verificar cuál formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type'])) {

    if ($_POST['form_type'] == "go_to_capitulo") {
        if (isset($_POST['id_capitulo'])) {
            $id_capitulo = $_POST['id_capitulo'];
            // Redirigir a la página capitulos.php con el IdCapitulo
            header("Location: capitulos.php?id_manga=" . $id_manga . "&id_capitulo=" . $id_capitulo);
            exit();
        } else {
            // Manejar el caso en que no se proporciona el IdCapitulo
        }
    }

    if ($_POST['form_type'] == "add_to_favorites") {
        // Lógica para añadir a favoritos

        if ($id_manga > 0 && !empty($id_usuario)) {
            // Comprobar si el usuario tiene un plan con un ID diferente de 1
            $sql_check = "SELECT IdPlan FROM Usuario WHERE IdUsuario = ?";
            if ($stmt_check = $conn->prepare($sql_check)) {
                $stmt_check->bind_param("i", $id_usuario);
                $stmt_check->execute();
                $stmt_check->bind_result($plan_id);
                $stmt_check->fetch();
                $stmt_check->close();

                if ($plan_id != 1) {
                    // Preparar la consulta SQL para insertar en favorito
                    $sql = "INSERT INTO favorito (IdManga, IdUsuario) VALUES (?, ?)";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("ii", $id_manga, $id_usuario);

                        if ($stmt->execute()) {
                            echo "
                            <div class='alert alert-dismissible alert-info' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            <strong>Ahora puedes encontrar este manga en tu seccion de favoritos!</strong></div>
                            ";
                        } else {
                            echo "<div class='alert alert-dismissible alert-secondary' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            <strong>Este manga ya se encuentra en tu seccion de favoritos!</strong></div>";
                        }

                        $stmt->close();
                    } else {
                        echo "Error en la preparación de la consulta: " . $conn->error;
                    }
                } else {
                    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Necesitas ser premium para utilizar esta funcion!</strong></div>";
                }
            } else {
                echo "Error en la preparación de la consulta de verificación: " . $conn->error;
            }
        } else {
            echo "ID de manga o usuario no válido.";
        }
    } elseif ($_POST['form_type'] == "add_comment") {
        // Lógica para añadir comentarios

        if (isset($_POST['accion']) && $_POST['accion'] == 'Nombre del Usuario') {
            // Obtener los datos del formulario
            $contenido_comentario = $_POST['content'];

            // Comprobar el plan del usuario
            $sql_check_plan = "SELECT IdPlan FROM Usuario WHERE IdUsuario = ?";
            $stmt_check_plan = $conn->prepare($sql_check_plan);
            $stmt_check_plan->bind_param("i", $id_usuario);
            $stmt_check_plan->execute();
            $stmt_check_plan->bind_result($plan_id);
            $stmt_check_plan->fetch();
            $stmt_check_plan->close();

            // Verificar si el usuario tiene un plan premium
            if ($plan_id != 1) {
                // Si el usuario es premium, realizar la inserción del comentario
                if (!empty($id_usuario) && !empty($id_manga) && !empty($contenido_comentario)) {
                    // Preparar la consulta SQL
                    $stmt = $conn->prepare("INSERT INTO comentario (IdUsuario, IdManga, ContenidoComentario, FechaComentario) VALUES (?, ?, ?, NOW())");
                    $stmt->bind_param("iis", $id_usuario, $id_manga, $contenido_comentario);

                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-dismissible alert-secondary' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        <strong>Comentario añadido exitosamente!</strong></div>";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    // Cerrar la declaración
                    $stmt->close();
                } else {
                    echo "Todos los campos son requeridos.";
                }
            } else {
                // Si el usuario no es premium, mostrar un mensaje de que necesita ser premium
                echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Necesitas ser premium para comentar!</strong></div>";
            }
        }
    }
}



// Consulta SQL para obtener los comentarios del manga específico ordenados por fecha de manera descendente
$sql = "SELECT comentario.*, usuario.Nombre 
        FROM comentario 
        INNER JOIN usuario ON comentario.IdUsuario = usuario.IdUsuario 
        WHERE comentario.IdManga = ? 
        ORDER BY FechaComentario DESC";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error en la consulta SQL: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $id_manga);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];

if ($result->num_rows > 0) {
    // Almacenar los resultados en la variable $comments
    while ($row = $result->fetch_assoc()) {
        $row['FechaComentario'] = date_create($row['FechaComentario'])->format('j \d\e F \d\e\l Y \a \l\a\s H:i');
        $comments[] = $row;
    }
} else {
    echo "";
}

// Cerrar la conexión
$stmt->close();

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
        color: whitesmoke;
        border-color: whitesmoke;
    }

    .btn-outline-primary:hover {
        color: turquoise;

        border-color: turquoise;
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
                    <div class="card-body d-flex flex-column justify-content-between text-start">
                        <h5 class="card-title"><?php echo $manga['Titulo']; ?></h5>
                        <form action="" method="post">
                            <input type="hidden" name="form_type" value="add_to_favorites">
                            <button type="submit" class="btn btn-lg btn-outline-primary">
                                <i class="fa-solid fa-plus"></i>Añadir a Favoritos
                            </button>
                        </form>
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
                    <form action="" method="POST">
                        <input type="hidden" name="form_type" value="go_to_capitulo">
                        <input type="hidden" name="id_capitulo" value="<?php echo $capitulo['IdCapitulo']; ?>">
                        <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                            <?php echo $capitulo['NombreCapitulo']; ?>


                            <button type="submit" class="btn btn-sm btn-outline-secondary">Leer</button>
                    </form>
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        #commentForm input,
        #commentForm textarea {
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
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
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
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
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

                <h2>Comentarios</h2>

                <!-- Formulario para agregar nuevos comentarios -->
                <h3 style="color: #6f42c1;">Añadir un comentario</h3>
                <form id="commentForm" method="post">
                    <input type="hidden" name="form_type" value="add_comment">
                    <input type="hidden" id="author" name="accion" value="Nombre del Usuario">
                    <label for="content">Comentario:</label>
                    <textarea id="content" name="content" required></textarea>
                    <button type="submit">Enviar<i class="fa-regular fa-paper-plane m-2"></i></button>
                </form>

                <div id="commentsContainer">
                    <?php if (!empty($comments)) : ?>
                        <?php foreach ($comments as $comment) : ?>


                            <div class="comment">
                                <div class="comment-author"><?php echo $comment['Nombre']; ?></div>
                                <div class="comment-content"><?php echo htmlspecialchars($comment['ContenidoComentario']); ?></div>
                                <div class="comment-date"><?php echo $comment['FechaComentario']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h5>No hay comentarios disponibles.</h5>
                    <?php endif; ?>

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