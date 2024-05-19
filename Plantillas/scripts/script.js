document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('paymentModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.querySelector('.close-btn');
    const cardContainer = document.querySelector('.card-container');
    
    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'flex';
    });
    
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    cardContainer.addEventListener('dblclick', function() {
        cardContainer.classList.toggle('double-clicked');
    });
});
