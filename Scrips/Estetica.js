

function expandHeader() {
    var header = document.querySelector('.header');
    var navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse.classList.contains('show')) {
        header.classList.add('expanded');
    } else {
        header.classList.remove('expanded');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var toggler = document.querySelector('.navbar-toggler');
    toggler.addEventListener('click', function() {
        expandHeader();
    });
});

// Obtener el elemento donde se mostrará el número de visualizaciones
var visualizationCountElement = document.getElementById('visualizationCount');

// Simular el conteo de visualizaciones
var visualizationCount = 0;

// Función para actualizar el número de visualizaciones
function updateVisualizationCount() {
    visualizationCount++;
    visualizationCountElement.textContent = visualizationCount;
}

// Llamar a la función de actualización cuando la página se cargue
window.addEventListener('load', updateVisualizationCount)