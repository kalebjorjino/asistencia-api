var tabla;

function init(){
    $("#oficina_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#oficina_form")[0]);
    $.ajax({
        url: "../../controller/oficina.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){    
            console.log(datos);
            $('#oficina_form')[0].reset();
            $("#modalOficina").modal('hide');
            $('#datatable-buttons').DataTable().ajax.reload();

            swal({
                title: "Oficina!",
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
            url: '../../controller/oficina.php?op=listar',
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

     $.post("../../controller/oficina.php?op=combo",function(data, status){
        $('#id_oficina').html(data);
    });

  
});

function editar(id_oficina){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/oficina.php?op=mostrar", {id_oficina : id_oficina}, function (data) {
        data = JSON.parse(data);
        $('#id_oficina').val(data.id_oficina);
        $('#nombre_oficina').val(data.nombre_oficina);
        $('#direccion_oficina').val(data.direccion_oficina);
    }); 

    $('#modalOficina').modal('show');
}

function eliminar(id_oficina){
    swal({
        title: "Oficina",
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
            $.post("../../controller/oficina.php?op=eliminar", {id_oficina : id_oficina}, function (data) {

            }); 

            $('#datatable-buttons').DataTable().ajax.reload();	

            swal({
                title: "Oficina!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
  
    
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#oficina_form')[0].reset();
    $('#modalOficina').modal('show');
});


init();