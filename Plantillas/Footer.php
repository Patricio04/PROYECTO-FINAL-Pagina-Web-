<?php
$url="http://".$_SERVER['HTTP_HOST']."/PROYECTO-FINAL-Pagina-Web-"; 
// Esto sirve para redireccionar a la carpeta principal del proyecto (por el momento se llama "PROYECTO-FINAL-Pagina-Web-"), ['HTTP_HOST'] sirve para colocar al principio el nombre del host actual (por el momento el host es "localhost"), esto para que si lo llegamos a subir y le cambiamos el nombre al host por algo como "Tatsu.com" ahora este sea el nombre del HOST y no haya inconvenientes con páginas que no se ven porque el direccionamiento está incorrecto

?>
<!-- Footer --> <!-- https://kit.fontawesome.com/9319846bc5.js, nos permite traer iconos con una clase en lugar de guardarlos como imagenes -->



<!-- Footer -->
<footer class="text-center text-lg-start  text-muted" id="Footer">


  <!-- Section: Links  -->
  <div class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Tatsu
          </h6>
          <p>
            Tatsu es una página dedicada al servicio de lectura de mangas Online.
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Products
          </h6>
          <p>
            <a href="#!" class="text-reset">Angular</a>
          </p>
          <p>
            <a href="#!" class="text-reset">React</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Vue</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Laravel</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Useful links
          </h6>
          <p>
            <a href="#!" class="text-reset">Pricing</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Settings</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Orders</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Help</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-3"></i> Pedro de Alba SN, Niños Héroes, Ciudad Universitaria, 66455 San Nicolás de los Garza, N.L.</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            patricio.loredonv@uanl.edu.mx
          </p>
          <p>
            <i class="fas fa-envelope me-3"></i>
LUIS.ACEVEDOSL@uanl.edu.mx
          </p>
          <p><i class="fas fa-phone me-3"></i> + 811233332</p>
          <p><i class="fas fa-print me-3"></i> + 811212121</p>
        </div>
        <div class="text-center p-4">
    © 2024 Copyright:
    <a class="text-reset fw-bold" href="#">MDBootstrap.com</a>
  </div>
      </div>
      <!-- Grid row -->
    </div>
  </d>
  <!-- Section: Links  -->

  <!-- Copyright -->
 
  <!-- Copyright -->
</footer>
<script src="scripts/script.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

<script src="https://kit.fontawesome.com/9319846bc5.js" crossorigin="anonymous"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script src="<?php echo $url . '/Scrips/biblioteca.js';?>"></script>

<script  src="<?php echo $url . '/Scrips/Estetica.js';?>" ></script>


</body>

</html>
