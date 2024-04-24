<?php
include '../Plantillas/Header.php';
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
        <!-- Aquí puedes agregar tus tarjetas de mangas -->
        <div class="col">
                    <div class="card shadow-sm position-relative">
                        <div class="title-container">
                            <h5 class="card-header">Título del manga muy largo que se truncaráaaaaaaaaaaaaaaaaaaaaa</h5>
                        </div>

                        <img src="https://th.bing.com/th/id/OIP.Q2X6hCBTGyfK8SRVDZNTRgHaLc?rs=1&pid=ImgDetMain" class="card-img-top" alt="Imagen de manga" style="width: 100%; height: 225px;">
                        <div class="card-body">
                            <p class="card-text">Esta es una prueba de la descripción que podría tener este manga</p>


                            <span class="badge rounded-pill btn btn-outline-info mb-3">Accion</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Comedia</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Terror</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Escolar</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Sci-fi</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Psicologico</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Romance</span>
                            <span class="badge rounded-pill btn btn-outline-info mb-3">Historia</span>


                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-light">Comenzar a leer</button>

                                </div>
                                <small class="text-body-secondary" id="visualizations">
                                    <i class="fas fa-eye"></i> <!-- Icono del ojo -->
                                    <span id="visualizationCount">0</span>
                                </small>



                            </div>
                        </div>
                    </div>
                </div>
        <!-- Agrega más tarjetas de mangas según necesites -->
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

