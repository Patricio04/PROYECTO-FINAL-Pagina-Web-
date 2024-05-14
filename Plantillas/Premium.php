<?php include './Header.php';
?>



    



    <!-- Apartado Premium -->
    <div class="container">
        <div class="plan-container">
            <div class="plan">
                <h3 class="animated-title">Plan Gratuito</h3>
                <div class="cat-animation"></div> <!-- Aquí se inserta la animación del gatito -->
                <div class="price">$0/mes</div>
                <ul class="features">
                    <li>Acceso básico a funciones</li>
                    <li>Soporte estándar</li>
                    <li>Actualizaciones mensuales</li>
                    <li>Foro de comunidad exclusivo</li>
                </ul>
                <button class="btn btn-success">
                    <i class="fa-solid fa-check"></i>Actual
                </button>
                <div class="btn-bg"></div>
            </div>

            <div class="plan">
                <h3 class="animated-title">Plan Premium</h3>
                <div class="price">$10/mes</div>
                <ul class="features">
                    <li>Acceso completo a todas las funciones</li>
                    <li>Soporte prioritario 24/7</li>
                    <li>Contenido exclusivo y adelantos</li>
                    <li>Descuentos en eventos y productos</li>
                </ul>
                <button class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Suscribirse
                </button>
                <div class="btn-bg"></div>
            </div>
        </div>
    </div>

    <?php
    include '../Plantillas/Footer.php';
    ?>
</>