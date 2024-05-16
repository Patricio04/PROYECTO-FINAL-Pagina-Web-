<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';

?>
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .chapter-container {
        background: linear-gradient(135deg, #6f42c1, #933c8d); /* Degradado de morado */
        padding: 20px; /* Espaciado interno */
        margin-bottom: 30px; /* Espaciado inferior */
        border-radius: 15px; /* Borde redondeado */
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5); /* Sombra morada con transparencia */
        position: relative; /* Posición relativa para el botón de siguiente capítulo */
    }
    .chapter-title {
        color: #fff; /* Color de texto blanco */
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem; /* Tamaño de fuente aumentado */
    }
    .chapter-content {
        text-align: center;
        margin-bottom: 30px;
    }
    .next-chapter-button {
        position: absolute;
        bottom: 10px; /* Alineado con el borde inferior */
        left: 75%;
        transform: translateX(-50%);
        background-color: #f8f9fa; /* Color de fondo */
        color: #6f42c1; /* Color de texto */
        border: none;
        padding: 15px 30px; /* Espaciado interno aumentado */
        border-radius: 50px; /* Borde redondeado */
        font-size: 1.2rem; /* Tamaño de fuente aumentado */
        cursor: pointer;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5); /* Sombra */
        transition: background-color 0.3s ease;
    }
    .next-chapter-button:hover {
        background-color: #e9ecef; /* Cambio de color al pasar el cursor */
    }
    .chapter-menu {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .chapter-menu a {
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #933c8d; /* Morado oscuro */
        transition: background-color 0.3s ease;
    }
    .chapter-menu a:hover {
        background-color: #6f42c1; /* Morado más claro */
    }
    .previous-chapter-button {
        position: absolute;
        bottom: 10px; /* Alineado con el borde inferior */
        left: 23%;
        transform: translateX(-50%);
        background-color: #f8f9fa; /* Color de fondo */
        color: #6f42c1; /* Color de texto */
        border: none;
        padding: 15px 30px; /* Espaciado interno aumentado */
        border-radius: 50px; /* Borde redondeado */
        font-size: 1.2rem; /* Tamaño de fuente aumentado */
        cursor: pointer;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5); /* Sombra */
        transition: background-color 0.3s ease;
    }
    .previous-chapter-button:hover {
        background-color: #e9ecef; /* Cambio de color al pasar el cursor */
    }

    /* Estilos adicionales para la lista desplegable */
    .chapter-list {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        padding: 10px;
        display: none;
        z-index: 1000;
    }
    .chapter-menu:hover .chapter-list {
        display: block;
    }
    .chapter-item {
        margin-bottom: 5px;
    }
</style>

<div class="container">
    <div class="chapter-container">
        <div class="chapter-menu">
        <div class="chapter-list">
                <div class="chapter-item">Capítulo 1</div>
                <div class="chapter-item">Capítulo 2</div>
                <div class="chapter-item">Capítulo 3</div>
                <!-- Agregar más capítulos según sea necesario -->
            </div>
            <a href="#" class="general-info-link"><i class="fas fa-home"></i> Información General del Manga</a>
        </div>
        <h1 class="chapter-title">Capítulo 1 - Nombre del Manga</h1>
        <div class="chapter-content">
            <!-- Contenido del capítulo (imagen, video, etc.) -->
            <img src="https://via.placeholder.com/800x600" alt="Contenido del capítulo">
        </div>
        <br>
        <!-- Botón para el capítulo anterior -->
        <button class="previous-chapter-button"><i class="fas fa-arrow-left"></i> Capítulo Anterior</button>
        <!-- Botón para ir al siguiente capítulo -->
        <button class="next-chapter-button">Siguiente Capítulo <i class="fas fa-arrow-right"></i></button>
    </div>
</div

<?php
include '../Plantillas/Footer.php';
?>