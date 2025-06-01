var tabla;

function init(){
    $("#unidad_form").on("submit",function(e){
        guardaryeditar(e);	
    });

     // Cargar los departamentos al inicio para el formulario de nueva unidad
    $.post("../../controller/departamento.php?op=combo",function(data, status){
        $('#id_departamento').html(data);
        console.log("Departamentos cargados en init():", data);
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#unidad_form")[0]);
    $.ajax({
        url: "../../controller/unidad.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){    
            console.log(datos);
            $('#unidad_form')[0].reset();
            $("#modalUnidad").modal('hide');
            $('#datatable-buttons').DataTable().ajax.reload();

            swal({
                title: "Unidad!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
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
            url: '../../controller/unidad.php?op=listar',
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

    

  
});

function editar(id_unidad){
    $('#mdltitulo').html('Editar Registro');

    // Primero, cargar los departamentos
    $.post("../../controller/departamento.php?op=combo", function(data) {
        $('#id_departamento').html(data);
        console.log("Departamentos cargados para editar:", data);

        // Luego, obtener los datos de la unidad
        $.post("../../controller/unidad.php?op=mostrar", {id_unidad : id_unidad}, function (data) {
            console.log("Datos de la unidad para editar:", data);
            data = JSON.parse(data);
            $('#id_unidad').val(data.id_unidad);

            // Intentar establecer el valor del departamento después de un pequeño delay
            setTimeout(function() {
                $('#id_departamento').val(data.id_departamento);
                console.log("Departamento establecido en editar:", data.id_departamento);
            }, 100); // Un pequeño retraso para asegurar que el select esté renderizado

            $('#nombre_unidad').val(data.nombre_unidad);
            $('#descripcion_unidad').val(data.descripcion_unidad);
            $('#modalUnidad').modal('show');
        });
    });
}

function eliminar(id_unidad){
    swal({
        title: "Unidad",
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
            $.post("../../controller/unidad.php?op=eliminar", {id_unidad : id_unidad}, function (data) {

            }); 

            $('#datatable-buttons').DataTable().ajax.reload();	

            swal({
                title: "Unidad!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
  
    
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#unidad_form')[0].reset();
    $('#modalUnidad').modal('show');
});


init();