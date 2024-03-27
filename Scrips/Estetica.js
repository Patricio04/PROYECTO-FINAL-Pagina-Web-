// Datos de paginación
const elementosTotales = 100; 
const elementosPorPagina = 10; 
const paginasAMostrar = 5; 

// Calcula el número total de páginas
const totalPaginas = Math.ceil(elementosTotales / elementosPorPagina);


let paginaActual = parseInt(new URLSearchParams(window.location.search).get('page')) || 1;

// Calcula el rango de páginas a mostrar en la paginación
let inicio = Math.max(Math.min(paginaActual - Math.floor(paginasAMostrar / 2), totalPaginas - paginasAMostrar + 1), 1);
let fin = Math.min(Math.max(paginaActual + Math.floor(paginasAMostrar / 2), paginasAMostrar), totalPaginas);

// Genera enlaces de página
let paginationHTML = '';
if (paginaActual > 1) {
    paginationHTML += `<li class="page-item"><a class="page-link" href="?page=${paginaActual - 1}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>`;
}

for (let i = inicio; i <= fin; i++) {
    paginationHTML += `<li class="page-item ${i === paginaActual ? 'active' : ''}"><a class="page-link" href="?page=${i}">${i}</a></li>`;
}

if (paginaActual < totalPaginas) {
    paginationHTML += `<li class="page-item"><a class="page-link" href="?page=${paginaActual + 1}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>`;
}

document.getElementById('pagination').innerHTML = paginationHTML;
