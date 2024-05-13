
/*
function loadGenresFromDatabase() {
    // Hacer una solicitud AJAX para base de datos
    fetch('../Scrips/dbgenero.php')
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            const genreSelect = document.querySelector('#filterModal .modal-body .mb-3');
            data.forEach(genre => {
                const checkboxDiv = document.createElement('div');
                checkboxDiv.classList.add('form-check', 'form-check-inline');
                
                const input = document.createElement('input');
                input.classList.add('form-check-input');
                input.type = 'checkbox';
                input.id = `genre${genre.id}`; // Asignar un ID único para el input
                
                const label = document.createElement('label');
                label.classList.add('form-check-label');
                label.setAttribute('for', `genre${genre.id}`); 
                label.textContent = genre.nombre; // Usar el nombre del género
                
                checkboxDiv.appendChild(input);
                checkboxDiv.appendChild(label);
                genreSelect.appendChild(checkboxDiv);
            });
        })
        .catch(error => {
            console.error('Error al obtener los géneros:', error);
        });
}


window.onload = loadGenresFromDatabase;
*/

function loadGenresFromDatabase() {
    // Hacer una solicitud AJAX para base de datos
    fetch('../Scrips/dbgenero.php')
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            const genreSelect = document.querySelector('#filterModal .modal-body .mb-3');
            data.forEach(genre => {
                const checkboxDiv = document.createElement('div');
                checkboxDiv.classList.add('form-check', 'form-check-inline');
                
                const input = document.createElement('input');
                input.classList.add('form-check-input');
                input.type = 'checkbox';
                input.id = `genre${genre.id}`; // Asignar un ID único para el input
                input.value = genre.nombre; // Asignar el valor de la etiqueta al input
                
                const label = document.createElement('label');
                label.classList.add('form-check-label');
                label.setAttribute('for', `genre${genre.id}`); 
                label.textContent = genre.nombre; // Usar el nombre del género
                
                checkboxDiv.appendChild(input);
                checkboxDiv.appendChild(label);
                genreSelect.appendChild(checkboxDiv);
            });
            
            // Aquí agregamos el event listener después de generar los checkboxes
            document.getElementById('BotonFiltrar').addEventListener('click', function() {
                filtrarMangas();
            });
        })
        .catch(error => {
            console.error('Error al obtener los géneros:', error);
        });
}

window.onload = loadGenresFromDatabase;




