//Funcion para activar los inputs en el formulario de "Mi cuenta"
$(document).ready(function(){
    $("#btnmodificar").click(function(event){
        event.preventDefault(); // esto es para que no se envie el formulario y no se actualice volviendo a mostrar los inputs en el estado disabled
        $("input").prop("disabled", false);
        $("#txtID").prop("disabled", true);
        $("#txtPlan").prop("disabled", true);
    });


});