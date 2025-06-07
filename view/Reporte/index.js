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

    // Inicializar la DataTable una única vez al cargar la página
    // La configuración AJAX ahora obtiene los valores de los filtros directamente antes de cada petición.
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
            url: '../../controller/reporte.php?op=listar_filtrado', // URL del controlador PHP para obtener datos
            type: "post", // Método de la petición
            dataType: "json", // Tipo de datos esperados
            data: function(d) {
                // Añadir parámetros de filtro a la petición AJAX
                // Estos valores se obtendrán justo antes de que se haga la petición AJAX
                d.id_empleado = $("#filtro_id_empleado").val();
                d.tardanza = $("#filtro_tardanza").val();
                d.horas_extras = $("#filtro_horas_extras").val();
                d.horas_trabajadas = $("#filtro_horas_trabajadas").val();
                d.fecha_inicio = $("#filtro_fecha_inicio").val();
                d.fecha_fin = $("#filtro_fecha_fin").val();
                d.periodicidad = $("#filtro_periodicidad").val();
            },
            error: function(e) {
                console.log(e.responseText);
                // Usar una modal o mensaje en lugar de alert() en producción
                alert("Error al cargar los datos. Verifique la consola.");
            }
        },
        // "bDestroy": true ya no es estrictamente necesario aquí si inicializamos una sola vez,
        // pero lo mantengo por si hay alguna otra lógica que lo necesite, aunque idealmente se eliminaría.
        "bDestroy": true, // Permite reinicializar la tabla si se usa listar() de otra forma
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

    // Evento para el botón Filtrar
    $("#btnFiltrar").on("click", function(){
        // Recargar la tabla con los nuevos parámetros de filtro
        // El 'null' es para el callback, 'false' para mantener la paginación actual
        tabla.ajax.reload(null, false); 
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
        tabla.ajax.reload(null, false);
    });
}

// La función listar() ya no se necesita como tal para inicializar la tabla,
// pero la mantengo si la usabas en otro lugar para otras cosas.
// Si solo era para la inicialización y filtrado, puedes eliminarla
// y dejar la lógica de inicialización en init().
function listar(){
    // Esta función ahora solo es un "wrapper" para la recarga,
    // o podría eliminarse si ya no se usa para la inicialización inicial.
    // Si la mantienes, asegúrate de que no cause una reinicialización
    // no deseada de DataTables.
    // tabla.ajax.reload(null, false); // Esto es lo que harías si la usaras.
    // Pero la lógica ya está directamente en init() y en los eventos de los botones.
    
    // Para asegurar que la tabla siempre se inicialice al principio,
    // y si 'listar' se llama después para una reinicialización completa (ej. si el DOM de la tabla se destruye completamente por otra razón),
    // puedes mantener la lógica de destrucción/creación aquí, pero es menos óptimo.
    // Es preferible la estrategia de "inicializar una vez y recargar".
    
    // Si la función 'listar' original tenía lógica específica para inicializar la tabla
    // solo cuando no existía, y luego recargar, esa lógica se ha movido al init().
    // Puedes borrar este bloque de comentarios y la función 'listar' si no la necesitas.
}


// Llamar a init al cargar el documento
$(document).ready(function() {
    init();
});


