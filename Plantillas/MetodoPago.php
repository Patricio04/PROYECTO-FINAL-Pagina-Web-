<?php 
include '../Assets/Bases de datos/db.php';
include './Header.php';


?>


<div class="pay-form">
    <div class="name-form">
      <img src="./images/Logo.png" width="48px" height="48px">
      <h1>Informacion de pago</h1>
    </div>
    <form id="form-pago" class="form-pago">
      <div class="nombre">
        <p>Nombre completo</p>
        <input type="text" placeholder="Gabriela Rojas" autocomplete="off">
      </div>
      <div class="numero-tarjeta">
        <p>Numero de Tarjeta de Credito</p>
        <input type="text" placeholder="1234 1234 1234 1234" maxlength="16" autocomplete="off">
      </div>
      <div class="date-tarjeta">
        <div class="exp-form">
          <p>Fecha de vencimiento</p>
          <input type="text" placeholder="MM/YY" maxlength="4" autocomplete="off">
        </div>
        <div class="cvv-form">
          <p>CVV</p>
          <input type="text" placeholder="***" maxlength="3" autocomplete="off">
        </div>
      </div>
      <div class="direccion-tarjeta">
        <p>Direccion</p>
        <input type="text" placeholder="Av.Bolognesi #234" autocomplete="off">
      </div>
      <button> Confirmar pago</button>
    </form>
    <h6>Verificas que esta informacion es correcta</h6>
  </div>