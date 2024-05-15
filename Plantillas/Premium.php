<?php
include '../Assets/Bases de datos/db.php';
include './Header.php';


/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['id_plan'] == 2) {
        
        header("Location: ./MetodoPago.php");
        exit(); 

    }   else {
        echo "<div class='alert alert-dismissible alert-info' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Ya cuentas con este plan activo!</strong> Te invitamos a pasarte a premium :D</div>";
    }
}
*/
$sql = "SELECT * FROM `planes`";
$resultado = $conn->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Array para almacenar los planes
    $planes = array();

    // Obtener los resultados y guardarlos en el array de planes
    while ($fila = $resultado->fetch_assoc()) {
        $planes[] = $fila;
    }

    // Liberar el resultado
    $resultado->free();
} else {
    // No se encontraron resultados
    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se encontaron planes disponibles!</strong> Contacte con el administrador.</div>";
}




?>







<!-- Apartado Premium -->
<div class="container">
    <div class="plan-container">
        <?php foreach ($planes as $plan) : ?>
            <div class="plan">
                <h3 class="animated-title"><?php echo $plan['TituloPlan']; ?></h3>
                <div class="cat-animation"></div> <!-- Aquí se inserta la animación del gatito -->
                <div class="price">$<?php echo $plan['PrecioPlan']; ?>/mes</div>
                <ul class="features">
                    <li><?php echo $plan['DescripcionPlan']; ?></li>
                </ul>
               
                <input type="hidden" class="id_plan" name="id_plan" value="<?php echo $plan['IdPlan']; ?>">

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#PagoModal">
                    <i class="fa-solid fa-shopping-cart"></i>Suscribirse
                </button>
                
                <div class="btn-bg"></div>
            </div>
        <?php endforeach; ?>

        
    </div>
</div>

<div class="modal fade" id="PagoModal" tabindex="-1" aria-labelledby="PagoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PagoModalLabel">Filtrar Mangas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Géneros</h6>
                <div class="mb-3">


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="BotonFiltrar">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>


<?php
include '../Plantillas/Footer.php';
?>
