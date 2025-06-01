var tabla;
var usu_id = $('#user_idx').val();
var rol_id = $('#rol_idx').val();
var dniOriginal = ""; // Variable para almacenar el DNI original en caso de edición

function init(){
    $("#empleado_form").on("submit",function(e){
        e.preventDefault();
        validarGuardar(e);
    });

     // Cargar los departamentos al inicio
    $.post("../../controller/departamento.php?op=combo",function(data, status){
        $('#id_departamento').html(data);
    });

    // Cargar las oficinas al inicio
    $.post("../../controller/oficina.php?op=combo",function(data, status){
        $('#id_oficina').html(data);
    });

    // Cargar los servicios al inicio
    $.post("../../controller/servicio.php?op=combo",function(data, status){
        $('#id_servicio').html(data);
    });
}

function validarGuardar(e){
    var dni = $("#dni").val();
    var nombre = $("#nombre").val();
    var profesion = $("#profesion").val();
    var id = $("#id").val(); // Obtener el ID para la validación de duplicados en edición

    // Validación de DNI (8 dígitos)
    if (!/^\d{8}$/.test(dni)) {
        swal("Validación", "El DNI debe tener 8 dígitos numéricos.", "warning");
        return false;
    }

    // Validación de Nombre (solo texto)
    if (!/^[a-zA-Z\s]+$/.test(nombre)) {
        swal("Validación", "El nombre solo debe contener letras y espacios.", "warning");
        return false;
    }

    // Validación de Profesión (solo texto)
    if (!/^[a-zA-Z\s]+$/.test(profesion)) {
        swal("Validación", "La profesión solo debe contener letras y espacios.", "warning");
        return false;
    }

    // Validación de duplicidad de DNI
    $.post("../../controller/empleado.php?op=validar_dni", { dni: dni, id: id, dniOriginal: dniOriginal }, function(data) {
        if (data === "existe") {
            swal("Validación", "El DNI ya existe en la base de datos.", "warning");
        } else {
            guardaryeditar(e); // Si las validaciones pasan, se llama a la función para guardar/editar
        }
    });
}

function guardaryeditar(e){
    var formData = new FormData($("#empleado_form")[0]);
    $.ajax({
        url: "../../controller/empleado.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            $('#empleado_form')[0].reset();
            $("#modalEmpleado").modal('hide');
            $('#datatable-buttons').DataTable().ajax.reload();

            swal({
                title: "Empleado!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
            dniOriginal = ""; // Resetear el DNI original después de guardar
        }
    });
}

$(document).ready(function(){
    
    if (rol_id==1){
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
            url: '../../controller/empleado.php?op=listar_empleados_x_usu',
            type : "post",
            dataType : "json",
            data:{ usu_id : usu_id },
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
    }else{
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
            url: '../../controller/empleado.php?op=listar_empleados',
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
    }

     $("#id_departamento").change(function(){
        var id_departamento = $(this).val();
        console.log("Departamento seleccionado:", id_departamento);

        // Cargar las unidades dependientes del departamento
        $.post("../../controller/unidad.php?op=comboCategoria",{id_departamento : id_departamento},function(data, status){
            $('#id_unidad').html(data);
            console.log("Unidades cargadas para el departamento:", data);
        });
    });

    
});



function editar(id){
    $('#mdltitulo').html('Editar Registro');

    // Primero, cargar los departamentos
    $.post("../../controller/departamento.php?op=combo", function(data) {
        $('#id_departamento').html(data);

        // Luego, obtener los datos del empleado
        $.post("../../controller/empleado.php?op=mostrar", {id : id}, function (empleadoData) {
            empleadoData = JSON.parse(empleadoData);
            $('#id').val(empleadoData.id);
            $('#dni').val(empleadoData.dni);
            $('#nombre').val(empleadoData.nombre);
            $('#profesion').val(empleadoData.profesion);
            $('#id_departamento').val(empleadoData.id_departamento);

            // Después de establecer el departamento, cargar las unidades correspondientes
            $.post("../../controller/unidad.php?op=comboCategoria", { id_departamento: empleadoData.id_departamento }, function(unidadData) {
                $('#id_unidad').html(unidadData);
                $('#id_unidad').val(empleadoData.id_unidad); // Seleccionar la unidad del empleado
            });

            $('#id_oficina').val(empleadoData.id_oficina);
            $('#id_servicio').val(empleadoData.id_servicio);
            dniOriginal = empleadoData.dni; // Guardar el DNI original al editar
            $('#modalEmpleado').modal('show');
        });
    });
}

function eliminar(id){
    swal({
        title: "Empleado",
        text: "¿Está seguro de Eliminar el registro?",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/empleado.php?op=eliminar", {id : id}, function (data) {
                $('#datatable-buttons').DataTable().ajax.reload();
                swal({
                    title: "Empleado!",
                    text: "Registro Eliminado.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#empleado_form')[0].reset();
    $('#modalEmpleado').modal('show');
    dniOriginal = ""; // Resetear el DNI original al crear un nuevo empleado
});

init();