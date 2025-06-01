var tabla;

// Inicialización de componentes
function init(){
    // Inicializar Datepickers
    $(".datepicker-input").datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });

    // Cargar DataTable inicial
    listar();

    // Evento para el botón Filtrar
    $("#btnFiltrar").on("click", function(){
        listar();
    });

    // Evento para el botón Limpiar
    $("#btnLimpiar").on("click", function(){
        // Limpiar campos del formulario
        $("#filtro_id_empleado").val("");
        $("#filtro_tardanza").val("");
        $("#filtro_horas_extras").val("");
        $("#filtro_horas_trabajadas").val("");
        $("#filtro_fecha_inicio").val("");
        $("#filtro_fecha_fin").val("");
        $("#filtro_periodicidad").val("");
        // Recargar tabla con filtros limpios
        listar();
    });
}

// Función para listar los datos en el DataTable
function listar(){
    // Obtener valores de los filtros
    var id_empleado = $("#filtro_id_empleado").val();
    var tardanza = $("#filtro_tardanza").val(); // "", "con", "sin"
    var horas_extras = $("#filtro_horas_extras").val(); // "", "con", "sin"
    var horas_trabajadas = $("#filtro_horas_trabajadas").val();
    var fecha_inicio = $("#filtro_fecha_inicio").val();
    var fecha_fin = $("#filtro_fecha_fin").val();
    var periodicidad = $("#filtro_periodicidad").val(); // "", "dia", "mes", "anio"

    // Destruir tabla existente si ya fue inicializada
    if ($.fn.DataTable.isDataTable("#datatable-asistencia")) {
        tabla.destroy();
    }

    tabla = $("#datatable-asistencia").DataTable({
        "aProcessing": true, // Activa el indicador de procesamiento
        "aServerSide": true, // Habilita el procesamiento del lado del servidor
        dom: 'Bfrtip', // Define los elementos del DOM para el control de la tabla (Botones, filtro, etc.)
        "searching": false, // Deshabilitar buscador general de DataTables, usamos filtros propios
        lengthChange: true, // Permitir cambiar número de registros por página
        colReorder: true,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ajax": {
            url: '../../controller/asistencia.php?op=listar_filtrado', // URL del controlador PHP para obtener datos
            type: "post", // Método de la petición
            dataType: "json", // Tipo de datos esperados
            data: function(d) {
                // Añadir parámetros de filtro a la petición AJAX
                d.id_empleado = id_empleado;
                d.tardanza = tardanza;
                d.horas_extras = horas_extras;
                d.horas_trabajadas = horas_trabajadas;
                d.fecha_inicio = fecha_inicio;
                d.fecha_fin = fecha_fin;
                d.periodicidad = periodicidad; // Enviar periodicidad, aunque el backend inicial no lo use para agrupar
            },
            error: function(e) {
                console.log(e.responseText);
                alert("Error al cargar los datos. Verifique la consola.");
            }
        },
        "bDestroy": true, // Permite reinicializar la tabla
        "responsive": true, // Diseño responsivo
        "bInfo": true, // Mostrar información de la tabla (ej. "Mostrando 1 a 10 de 57 registros")
        "iDisplayLength": 10, // Número de registros por defecto por página
        "pageLength": 10, // Asegura que lengthChange funcione correctamente
        "autoWidth": false, // Deshabilitar ajuste automático de ancho de columnas
        "order": [[2, 'desc']], // Ordenar por la columna de 'Entrada' (índice 2) descendente por defecto
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        // Definición de columnas (opcional, pero útil para mapear datos)
        "columns": [
            { "data": "idAsistencia" },
            { "data": "nombreEmpleado" },
            { "data": "horaEntrada" },
            { "data": "horaSalida" },
            { "data": "ubicacionAsistencia" },
            { 
                "data": "fotoAsistencia",
                "render": function(data, type, row) {
                    if(data){
                        // Asumiendo que la ruta base es relativa al controlador
                        return '<img src="../../public/' + data + '" height="50"/>'; 
                    } else {
                        return 'N/A';
                    }
                },
                "orderable": false // No permitir ordenar por foto
            },
            { "data": "tardanza" },
            { "data": "horas_trabajadas" },
            { "data": "horas_extras" },
            { 
                "data": "est",
                "render": function(data, type, row) {
                    // Asumiendo que 'est' 1 es activo, podrías querer mostrar algo más descriptivo
                    return data == 1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
                }
            }
        ]
    });
}

// Llamar a init al cargar el documento
$(document).ready(function() {
    init();
});

