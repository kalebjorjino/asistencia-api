var tabla;

function init(){
    $("#turno_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#turno_form")[0]);
    $.ajax({
        url: "../../controller/turno.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Esperar una respuesta JSON
        success: function(response){    
            // console.log(response);
            if (response.success) {
                $("#turno_form")[0].reset();
                $("#modalTurno").modal("hide");
                $("#datatable-buttons").DataTable().ajax.reload();
                swal({
                    title: "Turno",
                    text: response.success, // Mostrar mensaje de éxito del backend
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            } else if (response.info) {
                 // Mostrar mensaje informativo (ej. no se hicieron cambios)
                 $("#modalTurno").modal("hide"); // Opcional: cerrar modal también en info
                 swal({
                    title: "Turno",
                    text: response.info,
                    type: "info",
                    confirmButtonClass: "btn-info"
                });
            } else if (response.error) {
                // Mostrar mensaje de error del backend (ej. validación)
                swal({
                    title: "Error",
                    text: response.error,
                    type: "error",
                    confirmButtonClass: "btn-danger"
                });
            } else {
                 // Respuesta inesperada
                 swal({
                    title: "Error",
                    text: "Respuesta inesperada del servidor.",
                    type: "error",
                    confirmButtonClass: "btn-danger"
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            // Intentar obtener el mensaje de error del backend si está en la respuesta
            var errorMsg = "Error al procesar la solicitud.";
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                errorMsg = jqXHR.responseJSON.error;
            } else if (jqXHR.responseText) {
                // Intentar parsear si no es JSON
                try {
                     var parsed = JSON.parse(jqXHR.responseText);
                     if(parsed.error) {
                         errorMsg = parsed.error;
                     }
                } catch(e) {
                    // No hacer nada si no se puede parsear
                }
            }
             swal({
                title: "Error " + jqXHR.status, // Mostrar código de estado HTTP
                text: errorMsg,
                type: "error",
                confirmButtonClass: "btn-danger"
            });
            console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
        }
    }); 
}


$(document).ready(function(){
    tabla=$("#datatable-buttons").dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: "Bfrtip",
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                "copyHtml5",
                "excelHtml5",
                "csvHtml5",
                "pdfHtml5"
                ],
        "ajax":{
            url: "../../controller/turno.php?op=listar",
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
        "order": [[0, "desc"]],
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

  
});

function editar(id_turno){
    $("#mdltitulo").html("Editar Registro");

    $.post("../../controller/turno.php?op=mostrar", {id_turno : id_turno}, function (data) {
        // Parsear JSON ya que $.post no lo hace automáticamente por defecto como $.ajax con dataType
        try {
             data = JSON.parse(data);
             if (data.error) {
                 swal("Error", data.error, "error");
             } else {
                $("#id_turno").val(data.id_turno);
                $("#nombre").val(data.nombre);
                $("#hora_inicio").val(data.hora_inicio);
                $("#hora_fin").val(data.hora_fin);
                $("#tolerancia_minutos").val(data.tolerancia_minutos);
                $("#modalTurno").modal("show");
             }
        } catch (e) {
             swal("Error", "No se pudo obtener la información del turno.", "error");
             console.error("Error parsing JSON for editar:", e, data);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
         swal("Error", "No se pudo conectar con el servidor para obtener los datos.", "error");
         console.error("AJAX Error en editar:", textStatus, errorThrown);
    }); 

}

function eliminar(id_turno){
    swal({
        title: "Turno",
        text: "¿Está seguro de eliminar el registro?",
        type: "warning", // Cambiado a warning para confirmación
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true // Mostrar animación de carga
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "../../controller/turno.php?op=eliminar",
                type: "POST",
                data: { id_turno: id_turno },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#datatable-buttons").DataTable().ajax.reload();	
                        swal("Eliminado", response.success, "success");
                    } else if (response.info) {
                         swal("Información", response.info, "info");
                    } else {
                         swal("Error", response.error || "No se pudo eliminar el registro.", "error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var errorMsg = "Error al procesar la solicitud de eliminación.";
                     if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        errorMsg = jqXHR.responseJSON.error;
                    }
                    swal("Error " + jqXHR.status, errorMsg, "error");
                    console.error("AJAX Error en eliminar:", textStatus, errorThrown, jqXHR.responseText);
                }
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $("#mdltitulo").html("Nuevo Registro");
    $("#turno_form")[0].reset();
    // Limpiar ID oculto si existe
    $("#id_turno").val(""); 
    $("#modalTurno").modal("show");
});


init();
