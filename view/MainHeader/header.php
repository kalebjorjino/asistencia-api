<header id="topnav">
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-right-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <img src="../../public/assets/images/logo2.png" alt="user" class="rounded-circle"> <span
                        class="ml-1 font-weight-bold text-primary"><?php echo $_SESSION["usu_nom"] ?>
                    <?php echo $_SESSION["usu_ape"] ?><i class="mdi mdi-chevron-down "></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                    <!-- item-->
                    <a href="../Logout/logout.php" class="dropdown-item notify-item">
                        <i class="dripicons-power"></i><span class="font-weight-bold text-primary">Cerrar Sesión</span>
                    </a>

                </div>
            </li>
        </ul>

        <ul class="list-unstyled menu-left mb-0">
            <li class="float-left">
                <a href="index.html" class="logo">
                    <span class="logo-lg">
                        <img src="../../public/assets/images/logo2.png" alt="" height="50" width="50">
                    </span>
                    <span class="logo-sm">
                        <img src="../../public/assets/images/logo2.png" alt="" height="50" width="50">
                    </span>
                </a>
            </li>
            <li class="float-left">
                <a class="button-menu-mobile open-left navbar-toggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </li>
            <input  type="hidden" id="user_idx" value="<?php echo $_SESSION["usu_id"] ?>"><!-- ID del Usuario-->
            <input type="hidden" id="rol_idx" value="<?php echo $_SESSION["rol_id"] ?>"><!-- Rol del Usuario-->
        </ul>
    </nav>
    <!-- end navbar-custom -->
</header>