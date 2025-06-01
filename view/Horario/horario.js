var tabla;

function init(){
    $("#horario_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#horario_form")[0]);

    $.ajax({
        url: "../../controller/horario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            try {
                const datos = JSON.parse(respuesta);
                console.log(datos);

                if (datos.error) {
                    swal({
                        title: "Error",
                        text: datos.error,
                        type: "error",
                        confirmButtonClass: "btn-danger"
                    });
                } else if (datos.success) {
                    $('#horario_form')[0].reset();
                    $("#modalHorario").modal('hide');
                    $('#datatable-buttons').DataTable().ajax.reload();

                    swal({
                        title: "Horario!",
                        text: "Guardado correctamente.",
                        type: "success",
                        confirmButtonClass: "btn-success"
                    });
                } else {
                    swal({
                        title: "Atención",
                        text: "Respuesta inesperada del servidor.",
                        type: "warning"
                    });
                }

            } catch (e) {
                console.error("Error al procesar JSON:", e, respuesta);
                swal({
                    title: "Error",
                    text: "Ocurrió un problema inesperado. Revisa la consola para más detalles.",
                    type: "error"
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", status, error);
            swal({
                title: "Error",
                text: "No se pudo conectar con el servidor.",
                type: "error"
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
            url: '../../controller/horario.php?op=listar',
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

     $.post("../../controller/empleado.php?op=combo",function(data, status){
        $('#id_empleado').html(data);
    });

     $.post("../../controller/turno.php?op=combo",function(data, status){
        $('#id_turno').html(data);
    });

  
});

function editar(id_horario){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/horario.php?op=mostrar", {id_horario : id_horario}, function (data) {
        data = JSON.parse(data);
        $('#id_horario').val(data.id_horario);
        $('#id_empleado').val(data.id_empleado);
        $('#id_turno').val(data.id_turno);
        $('#fecha_inicio').val(data.fecha_inicio);
        $('#fecha_fin').val(data.fecha_fin);
    }); 

    $('#modalHorario').modal('show');
}

function eliminar(id_horario){
    swal({
        title: "Horario",
        text: "¿Estás seguro de eliminar el registro?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/horario.php?op=eliminar", {id_horario : id_horario}, function (data) {
                var respuesta = JSON.parse(data);
                if (respuesta.success) {
                    $('#datatable-buttons').DataTable().ajax.reload();	
                    swal("Horario!", "Registro eliminado correctamente.", "success");
                } else {
                    swal("Error", respuesta.error, "error");
                }
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#horario_form')[0].reset();
    $('#modalHorario').modal('show');
});


init();