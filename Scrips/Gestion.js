// Obtener las secciones de cada paso
const steps = document.querySelectorAll('.step');
let currentStep = 0;

// Función para mostrar el siguiente paso y ocultar el actual
function nextStep() {
    steps[currentStep].classList.add('hidden');
    currentStep++;
    if (currentStep < steps.length) {
        steps[currentStep].classList.remove('hidden');
    } else {
        // Si el usuario ha completado todos los pasos, redirigir o mostrar un mensaje de éxito
        alert('¡Registro completado con éxito!');
        // Aquí puedes redirigir al usuario a otra página si lo deseas
    }
}
