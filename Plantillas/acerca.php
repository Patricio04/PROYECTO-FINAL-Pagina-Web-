
<?php
include '../Assets/Bases de datos/db.php';
include './Header.php';
?>
 <link rel="stylesheet" href="../Styles/acerca.css">

 <div class="container">
        <header class="header">
            <h1>Acerca de Nosotros</h1>
        </header>
        <section class="about">
            <div class="photo-container">
                <div class="person">
                    <img src="data:image/jpg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAAeAAD/4QP1aHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA2LjAtYzAwMiA3OS4xNjQ0NjAsIDIwMjAvMDUvMTItMTY6MDQ6MTcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcFJpZ2h0cz0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3JpZ2h0cy8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtcFJpZ2h0czpNYXJrZWQ9IkZhbHNlIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc4ODA5RjNGRDU0MTExRUNCMzhCRjFERjMwM0VBQUZCIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc4ODA5RjNFRDU0MTExRUNCMzhCRjFERjMwM0VBQUZCIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzMgV2luZG93cyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkIwMzcxNjEzRDUzMTExRUNCRDZFOERENjVDRjQ5Qzc0IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkIwMzcxNjE0RDUzMTExRUNC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" alt="Foto de tu nombre" class="photo">
                    <p class="name">Patricio Loredo Navarro</p>
                </div>
                <div class="person">
                    <img src="../Img/foto.jpg" alt="Foto del nombre de tu colega" class="photo">
                    <p class="name">Luis Angel Acevedo Silva</p>
                </div>
            </div>
            <div class="info">
          
                <div class="description">
                    <p class="bubble"><strong>Patricio 2000192:</strong> Me encargue principalmente de la parte de frontend.</p>
                    <p class="bubble"><strong>Luis Angel </strong>Me enfoque en la parte backend , en la base de datos usando MyphpSQL.</p>
                </div>
            </div>
            <div class="gif-container">
                <img src="https://64.media.tumblr.com/68895e5441f8f5e21d8208664125390d/tumblr_nqdpj7ciKx1u1w094o1_540.gif" alt="GIF Cyberpunk" class="gif">
            </div>
        </section>
    </div>


    
<?php
include '../Plantillas/Footer.php';
?>