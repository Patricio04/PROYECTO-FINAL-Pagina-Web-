<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';

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
            color: #6c757d; /* Color de texto gris */
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
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card-container"> <!-- Contenedor de la tarjeta -->
                <div class="card shadow-sm d-flex flex-row card-neon">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen de manga">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">Nombre del Manga</h5>
                        <p class="card-text">Descripción del manga. Una historia emocionante sobre aventuras y desafíos.</p>
                        <div>
                            <span class="badge badge-pill badge-info">Acción</span>
                            <span class="badge badge-pill badge-info">Aventura</span>
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
            <h4>Capítulos</h4>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Capítulo 1
                    <a href="#" class="btn btn-sm btn-outline-secondary">Leer</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Capítulo 2
                    <a href="#" class="btn btn-sm btn-outline-secondary">Leer</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Capítulo 3
                    <a href="#" class="btn btn-sm btn-outline-secondary">Leer</a>
                </li>
            </ul>
        </div>
    </div>
 <br>

 <button class="show-comments-btn" onclick="showComments()">Mostrar comentarios</button>
        
 <div class="comments-section" id="commentsSection">
            <h2 style="color: #6f42c1;">Comentarios</h2>
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
            <!-- Agregar más comentarios según sea necesario -->
        </div>
    </div>
    
</div>
<script>
        function showComments() {
            var commentsSection = document.getElementById("commentsSection");
            if (commentsSection.style.display === "none") {
                commentsSection.style.display = "block";
            } else {
                commentsSection.style.display = "none";
            }
        }
    </script>
<?php
// Incluye el footer
include '../Plantillas/Footer.php';



?>