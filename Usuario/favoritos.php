<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';
//Como Prueba
$favoritos = [
    ['titulo' => 'Manga 1', 'imagen' => '../Img/Diamante.png'],
    ['titulo' => 'Manga 2', 'imagen' => 'https://m.media-amazon.com/images/M/MV5BZjE0YjVjODQtZGY2NS00MDcyLThhMDAtZGQwMTZiOWNmNjRiXkEyXkFqcGdeQXVyNTA4NzY1MzY@._V1_FMjpg_UX1000_.jpg'],
    ['titulo' => 'Manga 3', 'imagen' => 'manga3.jpg'],
    // Puedes agregar más mangas favoritos según sea necesario
];
?>
<!-- Contenido principal -->
<style>
    /* Estilos de la tarjeta y elementos adicionales */
    .cyberpunk-card {
        border-radius: 15px;
        background-color: #1a1a1a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
        position: relative;
        overflow: hidden;
    }

    .cyberpunk-card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        border-radius: 15px 15px 0 0;
        height: 200px; 
        object-fit: cover;
    }

    .card-title {
        color: #fff;
        font-family: 'Arial', sans-serif;
        font-size: 1.2rem;
        margin-top: 10px;
    }

    .card-body {
        padding: 15px;
    }

    .action-buttons {
        margin-top: 10px;
    }

    .btn-favorite,
    .btn-share {
        margin-right: 5px;
        background-color: #6f42c1;
        border-color: #6f42c1;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-favorite:hover,
    .btn-share:hover {
        background-color: #933c8d;
        border-color: #933c8d;
    }

    /* Estilos de la sección de usuario */
    .user-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #1a1a1a;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .user-profile {
        display: flex;
        align-items: center;
    }

    .profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
    }

    .user-info {
        color: #fff;
    }

    .user-name {
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    .user-details {
        font-size: 0.9rem;
    }

    /* Efecto de partículas */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }
</style>

<div id="particles-js" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Tus Mangas Favoritos</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($favoritos as $manga) : ?>
            <div class="col">
                <div class="card cyberpunk-card">
                    <img src="<?php echo $manga['imagen']; ?>" class="card-img-top" alt="Imagen de manga">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $manga['titulo']; ?></h5>
                        <div class="action-buttons">
                            <button class="btn btn-outline-light btn-favorite"><i class="fas fa-heart"></i></button>
                            <button class="btn btn-outline-light btn-share"><i class="fas fa-share-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Sección de usuario con foto de perfil  -->
    <div class="user-section mt-5">
        <div class="user-profile">
            <img src="https://i.pinimg.com/736x/57/b9/71/57b9714ccc972fa4efbe7b47c404f6c2.jpg" alt="Foto de perfil" class="profile-picture">
            <div class="user-info">
                <h4 class="user-name">Usuario</h4>
                <p class="user-details">Correo electrónico: usuario@example.com</p>
            </div>
        </div>
      
    </div>
</div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    //  partículas
    particlesJS("particles-js", {
    "particles": {
        "number": {
            "value": 100,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#ff00ff" 
        },
        "shape": {
            "type": "circle"
        },
        "opacity": {
            "value": 0.5,
            "random": true
        },
        "size": {
            "value": 3,
            "random": true
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ff00ff", 
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 3, 
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "bounce", 
            "bounce": true 
        }
    },
    "interactivity": {
        "events": {
            "onhover": {
                "enable": true,
                "mode": "bubble" 
            },
            "onclick": {
                "enable": true,
                "mode": "repulse"
            }
        }
    }
});
    </script>


    
    <?php
include '../Plantillas/Footer.php';
?>