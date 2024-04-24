<?php
include("./bd.php");
?>

<?php
include './template/Header.php';
?>

<main class="container_login">
<div class="container-sign"> 

<h1 class="title_login"> Iniciar Seccion</h1>
<form class="forms" action="procesar.login.php" method="POST">
    <div class="form-group">
        <label for="username"> Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password"> Contraseña :</label>
        <input type="text" id="password" name="password" required>
    </div>
    <button type="submit">Iniciar sesión</button>
</form>

</div>

</div>


<div class="container_login--form">

<form class="forms" action="procesar.login.php" method="POST">
    <div class="form-group">
        <label for="username"> Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password"> Contraseña :</label>
        <input type="text" id="password" name="password" required>
    </div>
    <button type="submit">Iniciar sesión</button>
</form>

</div>


</main>



<?php
include '../Plantillas/Footer.php';
?>
