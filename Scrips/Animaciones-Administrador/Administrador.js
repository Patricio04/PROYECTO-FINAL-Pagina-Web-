/*
show(): Muestra elementos ocultos con una animación.

hide(): Oculta elementos con una animación.

toggle(): Alterna entre mostrar y ocultar elementos con una animación.

fadeIn(): Muestra elementos gradualmente haciendo que se vuelvan transparentes.

fadeOut(): Oculta elementos gradualmente haciendo que se vuelvan transparentes.

fadeToggle(): Alterna entre mostrar y ocultar elementos con una animación de desvanecimiento.

fadeTo(): Cambia gradualmente la opacidad de los elementos a un valor específico.

slideDown(): Muestra elementos con una animación de deslizamiento hacia abajo.

slideUp(): Oculta elementos con una animación de deslizamiento hacia arriba.

slideToggle(): Alterna entre mostrar y ocultar elementos con una animación de deslizamiento. */

//animacion al momento de dar clic en un dropdown.
$(document).on('click', '.dropdown-toggle', function() {
    var dropdownMenu = $(this).next('.dropdown-menu');
    dropdownMenu.slideToggle(300);
});

//funcion al dar clic en el icono de la basura
$(document).ready(function() {
    // Manejar clic en enlaces de borrado
    $('.ancoreborrar').click(function(event) {
        event.preventDefault(); // Evitar que el enlace recargue la página

        // Obtener el ID del manga desde el atributo data-id
        var mangaId = $(this).data('id');

        // Encontrar la fila de la tabla que corresponde al manga y eliminarla
        $('#manga-' + mangaId).remove();
    });
});