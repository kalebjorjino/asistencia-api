<?php
if ($_SESSION["rol_id"]==1){
    ?>
<div class="left-side-menu bg-light shadow-sm">

    <div class="slimscroll-menu">

        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title text-muted">Navegación</li>
                <li class="nav-item">
                    <a href="..\Empleado\" class="nav-link">
                        <i class="mdi mdi-account mr-2"></i> <span class="font-weight-bold">Listado Asistencia</span>
                    </a>
                </li>
               

            </ul>

        </div>
        <div class="clearfix"></div>

    </div>
    </div>
<?php
}else{
    ?>
<div class="left-side-menu bg-light shadow-sm">

    <div class="slimscroll-menu">

        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title text-muted">Navegación</li>

              
                <li class="nav-item">
                    <a href="..\Empleado\" class="nav-link">
                        <i class="mdi mdi-account mr-2"></i> <span class="font-weight-bold">Listado Asistencia</span>
                    </a>
                </li>
            </ul>

        </div>
        <div class="clearfix"></div>

    </div>
    </div>
<?php
}
?>