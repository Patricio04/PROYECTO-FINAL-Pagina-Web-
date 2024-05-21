
<?php
include '../Assets/Bases de datos/db.php';
include './Header.php';

// Consulta SQL para obtener los tres mangas más vistos
$sql = "SELECT m.IdManga, m.Titulo, m.Portada, m.Descripcion, COUNT(v.IdVisualizacion) AS Visualizaciones, GROUP_CONCAT(e.NombreEtiqueta) AS Etiquetas
        FROM Manga m
        LEFT JOIN Visualizacion v ON m.IdManga = v.IdManga
        LEFT JOIN EtiquetaManga em ON m.IdManga = em.IdManga
        LEFT JOIN Etiqueta e ON em.IdEtiqueta = e.IdEtiqueta
        GROUP BY m.IdManga
        ORDER BY Visualizaciones DESC
        LIMIT 5";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $datosmangas = array();

    while ($fila = $resultado->fetch_assoc()) {
        $datosmangas[] = array(
            'id' => $fila['IdManga'],
            'titulo' => $fila['Titulo'],
            'portada' => $fila['Portada'],
            'descripcion' => $fila['Descripcion'],
            'visualizaciones' => $fila['Visualizaciones'],
            'etiquetas' => $fila['Etiquetas'] ? explode(',', $fila['Etiquetas']) : array()
        );
    }
} else {
    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se encontraron mangas disponibles</strong></div>";
}
?>
<style>
@font-face {
    font-family: 'Cyberpunk';
    src: url('path/to/your/cyberpunk-font.woff2') format('woff2'),
         url('path/to/your/cyberpunk-font.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}

.carrusel-container {
    width: 100%;
    overflow: hidden;
    position: relative;
    background-color: #000;
    padding: 20px 0;
}

.carrusel {
    display: flex;
    width: calc(200px * <?php echo count($datosmangas); ?>);
    animation: carruselAnim 20s linear infinite alternate;
}

.carrusel-item {
    flex: 0 0 auto;
    width: 200px;
    margin: 0 10px;
    position: relative;
}

.carrusel-item img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border: 1px solid #ccc;
}

.manga-header {
    font-family: 'Cyberpunk', sans-serif;
    font-size: 14px;
    padding: 2px 0;
    position: absolute;
    top: 0;
    width: 100%;
    background-color: black;
    color: white;
    text-align: center;
    z-index: 10;
}

@keyframes carruselAnim {
    0% {
        transform: translateX(0%);
    }
    50% {
        transform: translateX(-90%);
    }
    100% {
        transform: translateX(100%);
    }
}

.container-fluid{
    position: relative;
   
}
</style>
<section class="carrusel-mangas">
    <div class="carrusel-container">
        <div class="carrusel">
            <?php foreach ($datosmangas as $manga) : ?>
                <div class="carrusel-item">
                    <div class="manga-header">Manga</div>
                    <img src="<?php echo $manga['portada']; ?>" alt="<?php echo $manga['titulo']; ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carrusel = document.querySelector('.carrusel');
    const carruselContainer = document.querySelector('.carrusel-container');
    const carruselWidth = carruselContainer.offsetWidth;
    const numItems = carrusel.children.length;

    // Configurar la animación CSS inicial
    carrusel.style.animation = `carruselAnim 20s linear infinite`;

    // Escuchar el evento animationiteration para cambiar la dirección de la animación
    carrusel.addEventListener('animationiteration', () => {
        // Cambiar la dirección de la animación
        carrusel.style.animationDirection = carrusel.style.animationDirection === 'normal' ? 'reverse' : 'normal';
    });
});

</script>

<section class="mangas-populares">
    <h1 class="mpo">Mangas más Populares</h1>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
            <?php
            $sql = "SELECT m.IdManga, m.Portada, COUNT(f.IdManga) AS TotalFavoritos
                    FROM Manga m
                    LEFT JOIN Favorito f ON m.IdManga = f.IdManga
                    GROUP BY m.IdManga
                    ORDER BY TotalFavoritos DESC
                    LIMIT 5";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $rank = 1;
                while ($fila = $resultado->fetch_assoc()) {
                    ?>
                    <div class="col text-center">
                        <div class="image-container position-relative" style="display: inline-block; width: 150px; height: 150px;">
                            <div class="manga-header" style="position: absolute; top: 0; width: 100%; background-color: black; color: white; text-align: center; font-family: 'Cyberpunk', sans-serif; font-size: 12px; z-index: 10;">
                                Manga más favorito #<?php echo $rank; ?>
                            </div>
                            <img src="<?php echo $fila['Portada']; ?>" class="img-fluid" alt="Manga" style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #ccc;">
                            <a href="#" class="btn btn-danger btn-sm mt-2" style="position: absolute; bottom: 5px; right: 5px; z-index: 10;">
                                <i class="bi bi-heart-fill me-1"></i> 💜<?php echo $fila['TotalFavoritos']; ?>
                            </a>
                        </div>
                    </div>
                    <?php
                    $rank++;
                }
            } else {
                echo "<p class='text-center'>No se encontraron mangas populares en favoritos.</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- CSS for Cyberpunk Font and Styles -->
<style>
    @font-face {
        font-family: 'Cyberpunk';
        src: url('path/to/your/cyberpunk-font.woff2') format('woff2'),
             url('path/to/your/cyberpunk-font.woff') format('woff');
        font-weight: normal;
        font-style: normal;
    }

    .mpo {
        text-align: center;
        margin-bottom: 20px;
        font-family: 'Cyberpunk', sans-serif;
    }

    .mangas-populares .manga-header {
        font-family: 'Cyberpunk', sans-serif;
        font-size: 14px;
        padding: 2px 0;
    }

    .image-container {
        position: relative;
        display: inline-block;
        width: 150px;
        height: 150px;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-container .btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        z-index: 10;
    }
</style>



<?php
include '../Plantillas/Footer.php';
?>