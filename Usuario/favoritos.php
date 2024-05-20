<?php
include '../Assets/Bases de datos/db.php';
include '../Plantillas/Header.php';



// Comprobación del plan del usuario
$sql_check_plan = "SELECT IdPlan FROM Usuario WHERE IdUsuario = ?";
$stmt_check_plan = $conn->prepare($sql_check_plan);
$stmt_check_plan->bind_param("i", $id_usuario);
$stmt_check_plan->execute();
$stmt_check_plan->bind_result($plan_id);
$stmt_check_plan->fetch();
$stmt_check_plan->close();

if ($plan_id != 1) {
    // Si el usuario es premium, manejar las acciones
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_manga'])) {
        $id_manga = $_POST['id_manga'];

        if (isset($_POST['accion']) && $_POST['accion'] == 'leer') {
            // Lógica para comenzar a leer
            $conn->begin_transaction();

            try {
                // Insertar una nueva visualización
                $sql_insert = "INSERT INTO Visualizacion (IdUsuario, IdManga) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ii", $id_usuario, $id_manga);

                if (!$stmt_insert->execute()) {
                    throw new Exception("Error al insertar la visualización en la base de datos: " . $stmt_insert->error);
                }

                // Actualizar el contador de visualizaciones del manga
                $sql_update = "UPDATE Manga SET Visualizaciones = Visualizaciones + 1 WHERE IdManga = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("i", $id_manga);

                if (!$stmt_update->execute()) {
                    throw new Exception("Error al actualizar el contador de visualizaciones del manga: " . $stmt_update->error);
                }

                // Confirmar la transacción
                $conn->commit();

                // Redirigir a InfoManga.php con el ID del manga
                header("Location: InfoManga.php?id_manga=" . $id_manga);
                exit();
            } catch (Exception $e) {
                $conn->rollback();
                echo $e->getMessage();
            } finally {
                $stmt_insert->close();
                $stmt_update->close();
            }
        } elseif (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
            // Lógica para eliminar de favoritos
            $sql_delete = "DELETE FROM Favorito WHERE IdUsuario = ? AND IdManga = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("ii", $id_usuario, $id_manga);

            if ($stmt_delete->execute()) {
                // Redirigir de nuevo a la página de favoritos después de eliminar
                header("Location: favoritos.php");
                exit();
            } else {
                echo "Error al eliminar el manga de tus favoritos.";
            }

            $stmt_delete->close();
        }
    }

    // Obtener los favoritos con JOIN a la tabla Manga
    $sql_favoritos = "SELECT Manga.Portada, Manga.Titulo, Manga.IdManga 
                      FROM Favorito 
                      JOIN Manga ON Favorito.IdManga = Manga.IdManga 
                      WHERE Favorito.IdUsuario = ?";
    $stmt_favoritos = $conn->prepare($sql_favoritos);
    $stmt_favoritos->bind_param("i", $id_usuario);
    $stmt_favoritos->execute();
    $resultado_favoritos = $stmt_favoritos->get_result();

    // Crear un array para almacenar los datos de los favoritos
    $favoritos = array();

    // Recorrer los resultados y guardarlos en el array
    while ($fila = $resultado_favoritos->fetch_assoc()) {
        $favoritos[] = $fila;
    }

    $stmt_favoritos->close();
} else {
    // Si el usuario no es premium, redirigirlo a otra página
    header("Location: biblioteca.php");
    exit();
}

?>
<style>
    /* Estilos de la tarjeta y elementos adicionales */
    .cyberpunk-card {
        border-radius: 15px;
        background-color: #1a1a1a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
        position: relative;
        overflow: hidden;
    }

    .cyberpunk-card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        border-radius: 15px 15px 0 0;
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        color: #fff;
        font-family: 'Arial', sans-serif;
        font-size: 1.2rem;
        margin-top: 10px;
    }

    .card-body {
        padding: 15px;
    }

    .action-buttons {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        /* Espacio entre los botones */
    }

    .btn-favorite,
    .btn-share {
        margin-right: 5px;
        background-color: #6f42c1;
        border-color: #6f42c1;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-favorite:hover,
    .btn-share:hover {
        background-color: #933c8d;
        border-color: #933c8d;
    }

    /* Estilos de la sección de usuario */
    .user-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #1a1a1a;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .user-profile {
        display: flex;
        align-items: center;
    }

    .profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
    }

    .user-info {
        color: #fff;
    }

    .user-name {
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    .user-details {
        font-size: 0.9rem;
    }

    /* Efecto de partículas */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }
</style>

<div id="particles-js" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Tus Mangas Favoritos</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (!empty($favoritos)) : ?>
            <?php foreach ($favoritos as $favorito) : ?>
                <div class="col">
                    <div class="card cyberpunk-card">
                        <img src="<?php echo $favorito['Portada']; ?>" class="card-img-top" alt="Imagen de manga">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $favorito['Titulo']; ?></h5>
                            <div class="action-buttons">
                                <form method="POST" action="">
                                    <input type="hidden" class="id-manga" name="id_manga" value="<?php echo $favorito['IdManga']; ?>">
                                    <input type="hidden" name="accion" value="leer">
                                    <button class="btn btn-outline-light btn-favorite">Comenzar a leer</button>
                                </form>
                                <form method="POST" action="">
                                    <input type="hidden" class="id-manga" name="id_manga" value="<?php echo $favorito['IdManga']; ?>">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <button class="btn btn-outline-light btn-share"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            
                
            
                
            
        <?php endif; ?>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    //  partículas
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ff00ff"
            },
            "shape": {
                "type": "circle"
            },
            "opacity": {
                "value": 0.5,
                "random": true
            },
            "size": {
                "value": 3,
                "random": true
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ff00ff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 3,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "bounce",
                "bounce": true
            }
        },
        "interactivity": {
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "bubble"
                },
                "onclick": {
                    "enable": true,
                    "mode": "repulse"
                }
            }
        }
    });
</script>



<?php
include '../Plantillas/Footer.php';
?>