<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="contact-us" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Management Panel</span>
    </a>
<!-- Sidebar -->
    <div class="sidebar" name="sidebar-element" id="<?php echo isset($_SESSION["login-userid"])? $_SESSION['login-userid']:""; ?>">
        <!-- Sidebar user panel (optional) -->
        <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){ ?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="profile" class="d-block"><?php echo $_SESSION['login-email']; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-robot"></i>
                <p>
                    Component
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="search-page2" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <i class="fas fa-database"></i>
                    <p>Search</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    User
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="api_logout" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><i class="fas fa-arrow-right"></i> Log Out </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="profile" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><i class="fas fa-wrench"></i> Settings </p>
                    </a>
                </li>
                </ul>
            </li>
            <!--Basit admin menu-->
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-id-card"></i>
                <p>
                    Admin
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="passRecoverTables" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><i class="fas fa-gear"></i> Password recover requests </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="employeeOperations" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><i class="fas fa-users"></i> Employee operations </p>
                    </a>
                </li>
                </ul>
            </li>
            <?php } ?>
            <!--burdan aşagısı gereksiz-->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
        </aside>