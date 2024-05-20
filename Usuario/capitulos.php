<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';

//obtener id manga y capitulo desde el link
$id_manga = isset($_GET['id_manga']) ? intval($_GET['id_manga']) : 0;
$id_capitulo = isset($_GET['id_capitulo']) ? intval($_GET['id_capitulo']) : 0;

//obtener las imagenes del capitulo correspondiente
$contenidos = [];

$sql = "SELECT IdContenido, ImagenContenido, Orden FROM contenidocapitulo WHERE IdCapitulo = ? ORDER BY Orden ASC";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id_capitulo);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $contenidos[] = $row;
    }

    $stmt->close();
} else {
    die("Error en la preparación de la consulta: " . $conn->error);
}

//Obtener el nombre del manga segun el ID en el link
$titulo_manga = '';

$sql = "SELECT Titulo FROM Manga WHERE IdManga = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id_manga);
    $stmt->execute();
    $stmt->bind_result($titulo_manga);
    $stmt->fetch();
    $stmt->close();
} else {
    die("Error en la preparación de la consulta: " . $conn->error);
}

//Obtener el nombre del capitulo segun su ID
$nombre_capitulo = '';

$sql_capitulo = "SELECT NombreCapitulo FROM Capitulo WHERE IdCapitulo = ?";
if ($stmt_capitulo = $conn->prepare($sql_capitulo)) {
    $stmt_capitulo->bind_param("i", $id_capitulo);
    $stmt_capitulo->execute();
    $stmt_capitulo->bind_result($nombre_capitulo);
    $stmt_capitulo->fetch();
    $stmt_capitulo->close();
} else {
    die("Error en la preparación de la consulta de Capitulo: " . $conn->error);
}


?>
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .chapter-container {
        background: linear-gradient(135deg, #6f42c1, #933c8d);
        /* Degradado de morado */
        padding: 20px;
        /* Espaciado interno */
        margin-bottom: 30px;
        /* Espaciado inferior */
        border-radius: 15px;
        /* Borde redondeado */
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5);
        /* Sombra morada con transparencia */
        position: relative;
        /* Posición relativa para el botón de siguiente capítulo */
    }

    .chapter-title {
        color: #fff;
        /* Color de texto blanco */
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
        /* Tamaño de fuente aumentado */
    }

    .chapter-content {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0; /* Espaciado opcional alrededor del contenido */
        }

    .chapter-content img {
        text-align: center;
        margin-bottom: 30px;
        
            max-width: 800px;
            max-height: 600px;
            width: auto;
            height: auto;
        
    }

    .next-chapter-button {
        position: absolute;
        bottom: 10px;
        /* Alineado con el borde inferior */
        left: 75%;
        transform: translateX(-50%);
        background-color: #f8f9fa;
        /* Color de fondo */
        color: #6f42c1;
        /* Color de texto */
        border: none;
        padding: 15px 30px;
        /* Espaciado interno aumentado */
        border-radius: 50px;
        /* Borde redondeado */
        font-size: 1.2rem;
        /* Tamaño de fuente aumentado */
        cursor: pointer;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5);
        /* Sombra */
        transition: background-color 0.3s ease;
    }

    .next-chapter-button:hover {
        background-color: #e9ecef;
        /* Cambio de color al pasar el cursor */
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
        background-color: #933c8d;
        /* Morado oscuro */
        transition: background-color 0.3s ease;
    }

    .chapter-menu a:hover {
        background-color: #6f42c1;
        /* Morado más claro */
    }

    .previous-chapter-button {
        position: absolute;
        bottom: 10px;
        /* Alineado con el borde inferior */
        left: 23%;
        transform: translateX(-50%);
        background-color: #f8f9fa;
        /* Color de fondo */
        color: #6f42c1;
        /* Color de texto */
        border: none;
        padding: 15px 30px;
        /* Espaciado interno aumentado */
        border-radius: 50px;
        /* Borde redondeado */
        font-size: 1.2rem;
        /* Tamaño de fuente aumentado */
        cursor: pointer;
        box-shadow: 0 0 20px rgba(111, 66, 193, 0.5);
        /* Sombra */
        transition: background-color 0.3s ease;
    }

    .previous-chapter-button:hover {
        background-color: #e9ecef;
        /* Cambio de color al pasar el cursor */
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
        <h1 class="chapter-title"><?php echo htmlspecialchars($titulo_manga); ?>: <?php echo htmlspecialchars($nombre_capitulo); ?></h1>
        <?php if (!empty($contenidos)) : ?>
            <?php foreach ($contenidos as $contenido) : ?>
                <div class="chapter-content">
                    <!-- Contenido del capítulo (imagen, video, etc.) -->
                    <img src="<?php echo htmlspecialchars($contenido['ImagenContenido']); ?>" alt="Contenido del capítulo">
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay contenido disponible para este capítulo.</p>
        <?php endif; ?>
        <br>
        <!-- Botón para el capítulo anterior -->
        <button class="previous-chapter-button"><i class="fas fa-arrow-left"></i> Capítulo Anterior</button>
        <!-- Botón para ir al siguiente capítulo -->
        <button class="next-chapter-button">Siguiente Capítulo <i class="fas fa-arrow-right"></i></button>
    </div>
</div <?php
        include '../Plantillas/Footer.php';
        ?>