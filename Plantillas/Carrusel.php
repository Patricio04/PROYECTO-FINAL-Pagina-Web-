<section class="carrusel-mangas">
<div class="container-fluidd ">
        <div class="row">
            <!-- Columna para el carrusel -->
            <div class="col-lg-6">
                <!-- Carrusel de Bootstrap -->
                <div id="carouselExampleDark" class="carousel carousel-dark slide mb-5" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                            </div>
                        </div>
                        <!-- Agrega más elementos carousel-item según sea necesario -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <?php
include './Plantillas/Cards.php';
?>
            </section>