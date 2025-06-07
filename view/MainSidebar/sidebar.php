<?php
/* TODO: Rol 1 es de Usuario */
if ($_SESSION["rol_id"] == 1) {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="magenta">
                <a href="..\Asistencia\">
                    <span class="font-icon font-icon-contacts"></span>
                    <span class="lbl">Asistencias</span>
                </a>
            </li>
            <li class="blue-dirty">
                <a href="..\Empleado\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Empleados</span>
                </a>
            </li>
            
        </ul>
    </nav>
<?php
} else {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">

            <li class="magenta">
                <a href="..\Asistencia\">
                    <span class="font-icon font-icon-contacts"></span>
                    <span class="lbl">Asistencias</span>
                </a>
            </li>

            <li class="red">
                <a href="..\Empleado\">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Empleados</span>
                </a>
            </li>

            <!-- Gestión de Turnos -->
            <li class="green with-sub">
                <span>
                    <span class="glyphicon glyphicon-time"></span>
                    <span class="lbl">Gestión de Turnos</span>
                </span>
                <ul>
                    <li><a href="..\Turno\"><span class="lbl">Turnos</span></a></li>
                    <li><a href="..\Horario\"><span class="lbl">Horarios</span></a></li>
                    <li><a href="..\Dias_Laborales\"><span class="lbl">Días Laborales</span></a></li>
                </ul>
            </li>

            <!-- Estructura Organizacional -->
            <li class="green with-sub">
                <span>
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="lbl">Estructura Organizacional</span>
                </span>
                <ul>
                    <li><a href="..\Departamento\"><span class="lbl">Departamento</span></a></li>
                    <li><a href="..\Unidad\"><span class="lbl">Unidad</span></a></li>
                    <li><a href="..\Oficina\"><span class="lbl">Oficina</span></a></li>
                    <li><a href="..\Servicio\"><span class="lbl">Servicio</span></a></li>
                </ul>
            </li>
            
            <li class="blue-dirty">
                <a href="..\Reporte\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Reporte</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\Usuario\">
                    <span class="font-icon font-icon-user"></span>
                    <span class="lbl">Usuarios</span>
                </a>
            </li>

        </ul>
    </nav>
<?php
}
?>
