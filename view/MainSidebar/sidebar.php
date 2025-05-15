<?php
    /* TODO: Rol 1 es de Usuario */
    if ($_SESSION["rol_id"]==1){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Empleado\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Empleados</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
    }else{
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="magenta with-sub opened">
                        <a href="..\Empleado\">
                            <span class="font-icon font-icon-contacts"></span>
                            <span class="lbl">Asistencias</span>
                        </a>
                    </li>

                    <li class="red">
                        <a href="#">
                            <span class="font-icon font-icon-notebook"></span>
                            <span class="lbl">Empleados</span>
                        </a>
                    </li>
                    <li class="green with-sub opened">
                        <a href="#">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            <span class="lbl">Locales</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\Usuario">
                            <span class="font-icon font-icon-user"></span>
                            <span class="lbl">Usuarios</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
    }
?>
