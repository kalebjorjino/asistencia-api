var tabla;

function init(){
    $("#usuario_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            // Intentamos parsear la respuesta JSON
            try {
                var res = JSON.parse(datos);
                if(res.status === "error"){
                    // Mostrar alerta de error con mensaje personalizado
                    swal({
                        title: "Error",
                        text: res.message,
                        icon: "error",
                        button: "Aceptar"
                    });
                } else if(res.status === "success"){
                    // Operación exitosa
                    $('#usuario_form')[0].reset();
                    $("#modalUsuario").modal('hide');
                    $('#datatable-buttons').DataTable().ajax.reload();

                    swal({
                        title: "Usuario!",
                        text: "Completado.",
                        icon: "success",
                        button: "Aceptar"
                    });
                } else {
                    // Respuesta inesperada
                    swal({
                        title: "Error",
                        text: "Respuesta inesperada del servidor.",
                        icon: "error",
                        button: "Aceptar"
                    });
                }
            } catch(e) {
                // No es JSON o error en parseo
                swal({
                    title: "Error",
                    text: "Error procesando la respuesta del servidor.",
                    icon: "error",
                    button: "Aceptar"
                });
                console.error("Error parseando JSON:", e);
            }
        },
        error: function(xhr, status, error) {
            swal({
                title: "Error",
                text: "Error en la comunicación con el servidor.",
                icon: "error",
                button: "Aceptar"
            });
            console.error("Error en AJAX:", error);
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
            url: '../../controller/usuario.php?op=listar',
            type : "post",
            dataType : "json",						
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
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
    
      $.post("../../controller/empleado.php?op=combo",function(data, status){
        $('#id_empleado').html(data);
    });

});

function editar(usu_id){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/usuario.php?op=mostrar", {usu_id : usu_id}, function (data) {
        data = JSON.parse(data);
        $('#usu_id').val(data.usu_id);
        $('#id_empleado').val(data.id_empleado);
        $('#usu_correo').val(data.usu_correo);
        $('#usu_pass').val(data.usu_pass);
        $('#rol_id').val(data.rol_id).trigger('change');
    }); 

    $('#modalUsuario').modal('show');
}

function eliminar(usu_id){
    swal({
        title: "Usuario",
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
            $.post("../../controller/usuario.php?op=eliminar", {usu_id : usu_id}, function (data) {

            }); 

            $('#datatable-buttons').DataTable().ajax.reload();	

            swal({
                title: "Usuario!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
  
    
}



$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    $('#modalUsuario').modal('show');
});

init();