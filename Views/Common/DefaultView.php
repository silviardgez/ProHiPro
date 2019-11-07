<!DOCTYPE html>
<html
<head>
    <link rel="stylesheet" href="../CSS/default.css" />
    <script src="../JS/SidebarToggler.js"></script>
</head>
<body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
                <a id="button-sidebar" class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
                <button id="button-show-sidebar" class="navbar-toggler" type="button" onclick="showSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    TEC
                </a>
                <ul class="navbar-nav px-1">
                    <div class="row margin-right">
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="#" name="Profile">
                            <span class="feather-32 profile-margin" data-feather="user"></span>
                        </a>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a class="btn btn-light btn-logout" href="../Functions/Logout.php">Cerrar sesión</a>
                    </li>
                    </div>
                </ul>

        </nav>

        <div class="container-fluid">
            <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <nav id="sidebar-menu" class="d-md-block bg-light sidebar sidebar-expanded">
                    <div id="sidebar-contents" class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseUsers" href="#collapseUsers">
                                    <span class="fas fa-users"></span>
                                    Gestión de usuarios
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseUsers">
                                <li class="nav-item">
                                <a class="nav-link" href="../Controllers/UserController.php">
                                    Usuarios
                                </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        Permisos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controllers/ActionController.php">
                                        Accion
                                    </a>
                                </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="far fa-calendar"></span>
                                    Gestión de horarios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseDegree" href="#collapseDegree">
                                    <span class="fas fa-graduation-cap"></span>
                                    Gestión de titulaciones
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseDegree">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Titulaciones
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Asignaturas
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Grupos
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseDepartment" href="#collapseDepartment">
                                    <span class="fas fa-sitemap"></span>
                                    Gestión de departamentos
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseDepartment">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Departamentos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Profesores
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Tutorías
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseUniversity" href="#collapseUniversity">
                                    <span class="fas fa-university"></span>
                                    Gestión de universidades
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseUniversity">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Universidades
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Centros
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Edificios
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Espacios
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="fas fa-book"></span>
                                    Gestión de cursos académicos
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Importar/Exportar</span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="fas fa-file-alt"></span>
                                    PDA
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="fas fa-file-alt"></span>
                                    POD
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="fas fa-file-alt"></span>
                                    Informes
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</body>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
</html>