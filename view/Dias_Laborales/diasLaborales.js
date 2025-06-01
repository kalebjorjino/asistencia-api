var tabla;

function init(){
    $("#diaslab_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#diaslab_form")[0]);
    $.ajax({
        url: "../../controller/diasLaborales.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta){
            console.log(respuesta);
            var data = JSON.parse(respuesta);

            if(data.status === "success"){
                $('#diaslab_form')[0].reset();
                $("#modalDiasLab").modal('hide');
                $('#datatable-buttons').DataTable().ajax.reload();

                swal({
                    title: "¡Éxito!",
                    text: data.message,
                    icon: "success",
                    button: "Aceptar"
                });
            } else if(data.status === "error"){
                swal({
                    title: "Error",
                    text: data.message,
                    icon: "error",
                    button: "Aceptar"
                });
            } else {
                // Para otros casos no contemplados
                swal({
                    title: "Aviso",
                    text: "Ocurrió un error inesperado.",
                    icon: "warning",
                    button: "Aceptar"
                });
            }
        },
        error: function(e){
            console.log("Error en AJAX:", e.responseText);
            swal({
                title: "Error",
                text: "No se pudo procesar la solicitud.",
                icon: "error",
                button: "Aceptar"
            });
        }
    }); 
}


$(document).ready(function(){
    tabla=$('#datatable-buttons').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/diasLaborales.php?op=listar',
            type : "post",
            dataType : "json",						
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 20,
        "autoWidth": false,
        "order": [[0, 'desc']],
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable(); 

     $.post("../../controller/horario.php?op=combo",function(data, status){
        $('#id_horario').html(data);
    });

});

function editar(id){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/diasLaborales.php?op=mostrar", {id : id}, function (data) {
        data = JSON.parse(data);
        $('#id').val(data.id);
        $('#id_horario').val(data.id_horario);
        $('#dia').val(data.dia);
        $('#activo').val(data.activo);
    }); 

    $('#modalDiasLab').modal('show');
}

function eliminar(id){
    swal({
        title: "Dias Laboral",
        text: "Esta seguro de Eliminar el registro?",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
        
        
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/diasLaborales.php?op=eliminar", {id : id}, function (data) {

            }); 

            $('#datatable-buttons').DataTable().ajax.reload();	

            swal({
                title: "Horario!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
  
    
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#diaslab_form')[0].reset();
    $('#modalDiasLab').modal('show');
});


init();