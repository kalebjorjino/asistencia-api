var tabla;

function init(){
    $("#servicio_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#servicio_form")[0]);
    $.ajax({
        url: "../../controller/servicio.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){    
            console.log(datos);
            $('#servicio_form')[0].reset();
            $("#modalServicio").modal('hide');
            $('#datatable-buttons').DataTable().ajax.reload();

            swal({
                title: "Servicio!",
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
            url: '../../controller/servicio.php?op=listar',
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

function editar(id_servicio){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/servicio.php?op=mostrar", {id_servicio : id_servicio}, function (data) {
        data = JSON.parse(data);
        $('#id_servicio').val(data.id_servicio);
        $('#nombre_servicio').val(data.nombre_servicio);
        $('#descripcion_servicio').val(data.descripcion_servicio);
    }); 

    $('#modalServicio').modal('show');
}

function eliminar(id_servicio){
    swal({
        title: "Servicio",
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
            $.post("../../controller/servicio.php?op=eliminar", {id_servicio : id_servicio}, function (data) {

            }); 

            $('#datatable-buttons').DataTable().ajax.reload();	

            swal({
                title: "Servicio!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
  
    
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#servicio_form')[0].reset();
    $('#modalServicio').modal('show');
});


init();