<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';

/*
$sql = "SELECT * FROM Manga";
$resultado = $conn->query($sql);
*/
$sql = "SELECT m.IdManga, m.Titulo, m.Portada, m.Descripcion, m.Visualizaciones, GROUP_CONCAT(e.NombreEtiqueta) AS Etiquetas
        FROM Manga m
        LEFT JOIN EtiquetaManga em ON m.IdManga = em.IdManga
        LEFT JOIN Etiqueta e ON em.IdEtiqueta = e.IdEtiqueta
        GROUP BY m.IdManga";

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
        // print_r($datosmangas);
    }
} else {
    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se encontraron mangas disponibles</strong></div>";
}



// Verificar si el ID del manga está definido en $_POST
if (isset($_POST['id_manga'])) {
    // Obtener el ID del manga desde el formulario
    $id_manga = $_POST['id_manga']; // Este es el valor del atributo "value" del input hidden en tu formulario

    // Obtener el ID de usuario de la sesión
    $id_usuario = $_SESSION['IdUsuario'];

    // Iniciar la transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta para insertar una nueva visualización
        $sql_insert = "INSERT INTO Visualizacion (IdUsuario, IdManga) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $id_usuario, $id_manga);

        // Ejecutar la consulta de inserción
        if (!$stmt_insert->execute()) {
            throw new Exception("Error al insertar la visualización en la base de datos: " . $stmt_insert->error);
        }

        // Preparar la consulta para actualizar el contador de visualizaciones del manga
        $sql_update = "UPDATE Manga SET Visualizaciones = Visualizaciones + 1 WHERE IdManga = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $id_manga);

        // Ejecutar la consulta de actualización
        if (!$stmt_update->execute()) {
            throw new Exception("Error al actualizar el contador de visualizaciones del manga: " . $stmt_update->error);
        }

        // Confirmar la transacción
        $conn->commit();

        // Redirigir a la página InfoManga.php con el ID del manga
        header("Location: InfoManga.php?id_manga=" . $id_manga);
        exit();
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo $e->getMessage();
    } finally {
        // Cerrar las sentencias
        if (isset($stmt_insert)) $stmt_insert->close();
        if (isset($stmt_update)) $stmt_update->close();
    }
} else {
    // No se ha definido el ID del manga en $_POST
    echo "";
}


// Consulta SQL para obtener los datos de la tabla "etiquetas"
$sql = "SELECT * FROM Etiqueta;";

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Crear un array para almacenar los datos de las etiquetas
    $etiquetas = array();

    // Recorrer los resultados y guardarlos en el array
    while ($fila = $resultado->fetch_assoc()) {
        $etiquetas[] = $fila;
    }
} else {
    // Si no hay resultados, mostrar un mensaje
    echo "<p>No se encontraron etiquetas.</p>";
}


?>



<div class="container">
    <div class="filter-buttons" id="filters">
        <!-- Botones de filtro por etiquetas -->
        <button class="filter-button" data-filter="*">Mostrar todo</button>

        <?php foreach ($etiquetas as $etiqueta) { ?>
        <button class="filter-button" data-filter=".<?php echo $etiqueta['NombreEtiqueta'] ?>"><?php echo $etiqueta['NombreEtiqueta'] ?></button>
        <?php } ?>
        
        <!-- Agrega más botones de filtro según tus etiquetas -->
    </div>

    <div class="sort-buttons" id="sorts">
        <!-- Botones de ordenamiento por nombre ascendente y descendente -->
        <button class="sort-by-name-asc" data-sort-by="name" data-sort-order="asc">Ordenar por nombre A-Z</button>
        <button class="sort-by-name-desc" data-sort-by="name" data-sort-order="desc">Ordenar por nombre Z-A</button>
        <!-- Botón de ordenamiento por visualizaciones -->
        <button class="sort-button" data-sort-by="visualizations" data-sort-order="asc">Ordenar por visualizaciones (Ascendente)</button>
        <button class="sort-button" data-sort-by="visualizations" data-sort-order="desc">Ordenar por visualizaciones (Descendente)</button>
    </div>

    <button class="reset-filters">Restablecer filtros y orden</button>

    <!-- Tarjetas de mangas -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-5" id="manga-container">
        <?php foreach ($datosmangas as $manga) : ?>
            <!-- <a href="./InfoManga.php" class="text-decoration-none" onclick="document.getElementById('miFormulario').submit(); return false;">-->

            <!-- Aquí puedes agregar tus tarjetas de mangas -->
            <div class="col manga-card" data-etiquetas="<?php echo implode(' ', $manga['etiquetas']); ?>">
                <div class="card shadow-sm position-relative">
                    <div class="title-container">
                        <h5 class="card-header" id="TituloManga"><?php echo $manga['titulo']; ?></h5>

                    </div>

                    <img src="<?php echo $manga['portada']; ?>" class="card-img-top" alt="Imagen de manga" style="width: 100%; height: 200px;">
                    <div class="card-body">
                        <p class="card-text"><?php //echo $manga['descripcion']; 
                                                ?></p>

                        <?php foreach ($manga['etiquetas'] as $etiqueta) : ?>
                            <span class="badge rounded-pill btn btn-outline-info mb-3" value="<?php //echo $etiqueta; ?>"></span>
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
                                <form method="POST" id="miFormulario">
                                    <input type="hidden" class="id-manga" name="id_manga" value="<?php echo $manga['id']; ?>">

                                    <button type="submit" class="btn btn-sm btn-outline-light comenzar-leer">Comenzar a leer</button>

                                </form>
                            </div>
                            <small class="text-body-secondary" id="visualizations">
                                <i class="fas fa-eye"></i> <!-- Icono del ojo -->
                                <span class="visualizationCount"><?php echo $manga['visualizaciones']; ?></span>
                            </small>


                            <small class="text-body-secondary" id="visualizations">
                                <i class="far fa-heart favorite-icon"></i>
                                <span id="visualizationCount"><?php echo $manga['visualizaciones']; ?></span>
                            </small>

                        </div>
                    </div>
                </div>
            </div>
            <!-- </a> -->
            <!-- Agrega más tarjetas de mangas según necesites -->
        <?php endforeach; ?>
    </div>



</div>

<?php
include '../Plantillas/Footer.php';
?>

<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

<script>
    window.onload = function() {
        // init isotope
        var $listing = $('.row').isotope({
            itemSelector: '.col',
            layoutMode: 'fitRows',
            getSortData: {
                name: '.card-header',
                visualizations: '[data-visualizations] parseInt'
            }
        });

        // bind filter button click
        $("#filters").on("click", "button", function() {
            var filterValue = $(this).attr('data-filter');
            if (filterValue === '*') {
                $listing.isotope({ filter: '*' });
            } else {
                $listing.isotope({
                    filter: function() {
                        var etiquetas = $(this).attr('data-etiquetas').split(' ');
                        return etiquetas.includes(filterValue.substring(1)); // Remove the dot from filterValue
                    }
                });
            }
        });

        // bind sort button click
        $("#sorts").on("click", "button", function() {
            var sortValue = $(this).attr('data-sort-by');
            var sortOrder = $(this).attr('data-sort-order') === 'asc';
            $listing.isotope({
                sortBy: sortValue,
                sortAscending: sortOrder
            });
        });

        // bind reset button click
        $(".reset-filters").on("click", function() {
            // reset filters and sort order
            $listing.isotope({
                filter: '*',
                sortBy: 'original-order'
            });
        });
    };
</script>

    
</body>