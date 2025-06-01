var tabla;

function init(){
    $("#departamento_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#departamento_form")[0]);
    $.ajax({
        url: "../../controller/departamento.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){    
            console.log(datos);
            $('#departamento_form')[0].reset();
            $("#modalDepartamento").modal('hide');
            $('#datatable-buttons').DataTable().ajax.reload();

            swal({
                title: "Departamento!",
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
            url: '../../controller/departamento.php?op=listar',
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

     $.post("../../controller/departamento.php?op=combo",function(data, status){
        $('#id_departamento').html(data);
    });

  
});

function editar(id_departamento){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/departamento.php?op=mostrar", {id_departamento : id_departamento}, function (data) {
        data = JSON.parse(data);
        $('#id_departamento').val(data.id_departamento);
        $('#nombre_departamento').val(data.nombre_departamento);
        $('#descripcion_departamento').val(data.descripcion_departamento);
    }); 

    $('#modalDepartamento').modal('show');
}

function eliminar(id_departamento){
    swal({
        title: "Departamento",
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
            $.post("../../controller/departamento.php?op=eliminar", {id_departamento : id_departamento}, function (data) {

            }); 

            $('#datatable-buttons').DataTable().ajax.reload();	

            swal({
                title: "Departamento!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
  
    
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#departamento_form')[0].reset();
    $('#modalDepartamento').modal('show');
});


init();