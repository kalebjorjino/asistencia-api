function init(){
}

$(document).ready(function() {

});

$(document).on("click", "#btnadmin", function () {
    if ($('#rol_id').val()==1){
        $('#lbltitulo').html("Administrador");
        $('#btnadmin').html("Ingreso de Supervisor");
        $('#rol_id').val(2);
        
    }else{
        $('#lbltitulo').html("Ingreso de Supervisor");
        $('#btnadmin').html("Administrador");
        $('#rol_id').val(1);
    }
});

init();
