<!DOCTYPE html>
<html id="principal-page"
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
                    <li class="nav-item text-nowrap row flags">
                        <a href="javascript:setCookie('language-selected', 'gl'); translatePage();"><img class="flag" src="../Images/gl.png"></a>
                        <a href="javascript:setCookie('language-selected', 'es'); translatePage();"><img class="flag" src="../Images/es.jpg"></a>
                        <a href="javascript:setCookie('language-selected', 'en'); translatePage();"><img class="flag" src="../Images/en.jpg"></a>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="../Controllers/UserController.php?action=show&login=<?php echo $_SESSION['login'] ?>"
                           name="Profile">
                            <span class="feather-32 profile-margin" data-feather="user"></span>
                        </a>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a class="btn btn-light btn-logout" href="../Functions/Logout.php">
                            <p data-translate="Cerrar sesión"></p>
                        </a>
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
                                    <p data-translate="Gestión de usuarios"></p>
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseUsers">
                                <li class="nav-item">
                                <a class="nav-link" href="../Controllers/UserController.php">
                                    <p data-translate="Usuarios"></p>
                                </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controllers/FuncActionController.php">
                                        <p data-translate="Permisos"></p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controllers/PermissionController.php">
                                        <p data-translate="Asignación de permisos"></p>
                                    </a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" href="../Controllers/ActionController.php">
                                        <p data-translate="Acciones"></p>
                                    </a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" href="../Controllers/FunctionalityController.php">
                                        <p data-translate="Funcionalidades"></p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controllers/RoleController.php">
                                        <p data-translate="Roles"></p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controllers/UserRoleController.php">
                                        <p data-translate="Asignación de Roles"></p>
                                    </a>
                                </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="far fa-calendar"></span>
                                    <p data-translate="Gestión de horarios"></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseDegree" href="#collapseDegree">
                                    <span class="fas fa-graduation-cap"></span>
                                    <p data-translate="Gestión de titulaciones"></p>
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseDegree">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Titulaciones"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Asignaturas"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Grupos"></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseDepartment" href="#collapseDepartment">
                                    <span class="fas fa-sitemap"></span>
                                    <p data-translate="Gestión de departamentos"></p>
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseDepartment">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Departamentos"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Profesores"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Tutorías"></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseUniversity" href="#collapseUniversity">
                                    <span class="fas fa-university"></span>
                                    <p data-translate="Gestión de universidades"></p>
                                </a>
                                <ul class="flex-column collapse items-collapsed" id="collapseUniversity">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Universidades"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Centros"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Edificios"></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <p data-translate="Espacios"></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Controllers/AcademicCourseController.php">
                                    <span class="fas fa-book"></span>
                                    <p data-translate="Gestión de cursos académicos"></p>
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span data-translate="Importar/Exportar"></span>
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
                                    <p data-translate="Informes"></p>
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