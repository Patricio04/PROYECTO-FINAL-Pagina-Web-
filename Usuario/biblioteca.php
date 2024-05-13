<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';

/*
$sql = "SELECT * FROM Manga";
$resultado = $conn->query($sql);
*/
$sql = "SELECT m.IdManga, m.Titulo, m.Portada, m.Descripcion, m.Visualizaciones, e.NombreEtiqueta
FROM Manga m
JOIN EtiquetaManga em ON m.IdManga = em.IdManga
JOIN Etiqueta e ON em.IdEtiqueta = e.IdEtiqueta";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    // Crear un array asociativo para almacenar los mangas y sus etiquetas
    $datosmangas = array();

    // Iterar sobre cada fila de resultado
    while ($fila = $resultado->fetch_assoc()) {
        // Verificar si ya existe una entrada para este manga en el array
        $idManga = $fila['IdManga'];
        if (!isset($datosmangas[$idManga])) {
            // Si no existe, crear una nueva entrada con los datos del manga
            $datosmangas[$idManga] = array(
                'id' => $idManga,
                'titulo' => $fila['Titulo'],
                'portada' => $fila['Portada'],
                'descripcion' => $fila['Descripcion'],
                'visualizaciones' => $fila['Visualizaciones'],
                'etiquetas' => array() // Crear un subarray para almacenar las etiquetas
            );
        }

        // Si este manga tiene una etiqueta asociada, agregarla al array de etiquetas
        if ($fila['NombreEtiqueta']) {
            $datosmangas[$idManga]['etiquetas'][] = $fila['NombreEtiqueta'];
        }
    }
} else {
    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se encontraron mangas disponibles</strong></div>";
}


?>



<?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/PROYECTO-FINAL-Pagina-Web-" ?> <!-- Esto sirve para redireccionar a la carpeta principal del proyecto (por el momento se llama "PROYECTO-FINAL-Pagina-Web-"), ['HTTP_HOST'] sirve para colocar al principio el nombre del host actual (por el momento el host es "localhost"), esto para que si lo llegamos a subir y le cambiamos el nombre al host por algo como "Tatsu.com" ahora este sea el nombre del HOST y no haya inconvenientes con páginas que no se ven porque el direccionamiento está incorrecto-->
<div class="container">
    <h1 class="my-4">Biblioteca de Mangas</h1>

    <!-- Botones de filtros -->
    <div class="mb-4" id="filterButtons">
        <!-- Los botones de filtro se generarán dinámicamente aquí -->
    </div>

    <!-- Botón de filtro personalizado -->
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filtrar</button>
    </div>

    <!-- Tarjetas de mangas -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($datosmangas as $manga) : ?>
            <!-- Aquí puedes agregar tus tarjetas de mangas -->
            <div class="col">
                <div class="card shadow-sm position-relative">
                    <div class="title-container">
                        <h5 class="card-header"><?php echo $manga['titulo']; ?></h5>
                    </div>

                    <img src="<?php echo $manga['portada']; ?>" class="card-img-top" alt="Imagen de manga" style="width: 100%; height: 225px;">
                    <div class="card-body">
                        <p class="card-text"><?php echo $manga['descripcion']; ?></p>

                        <?php foreach ($manga['etiquetas'] as $etiqueta) : ?>
                            <span class="badge rounded-pill btn btn-outline-info mb-3"><?php echo $etiqueta; ?></span>
                        <?php endforeach; ?>
                        <!--
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Comedia</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Terror</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Escolar</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Sci-fi</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Psicologico</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Romance</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Historia</span>  
                        -->


                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-light">Comenzar a leer</button>

                            </div>
                            <small class="text-body-secondary" id="visualizations">
                                <i class="fas fa-eye"></i> <!-- Icono del ojo -->
                                <span id="visualizationCount"><?php echo $manga['visualizaciones']; ?></span>
                            </small>



                        </div>
                    </div>
                </div>
            </div>
            <!-- Agrega más tarjetas de mangas según necesites -->
        <?php endforeach; ?>
    </div>


    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-4">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>



<!-- Modal de filtro -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filtrar Mangas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Géneros</h6>
                <div class="mb-3">

                    <!-- Agrega más géneros según tus necesidades -->
                </div>
                <h6>Ordenar por</h6>
                <div class="mb-3">
                    <select class="form-select" id="orderBy">
                        <option value="recent">Más recientes</option>
                        <option value="popular">Más populares</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="applyFilters()">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>


<?php
include '../Plantillas/Footer.php';
?>