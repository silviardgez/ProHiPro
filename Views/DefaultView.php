<!DOCTYPE html>
<html
<head>
    <title>TEC</title>
    <meta charset="utf-8">
    <meta name="description" content="Place your description here">
    <meta name="author" content="ProHiPro">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/default.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
                <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
                    <span class="feather-24 profile-margin" data-feather="home"></span>
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
                        <a class="btn btn-light btn-logout" href="#">Cerrar sesión</a>
                    </li>
                    </div>
                </ul>

        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseUsers" href="#collapseUsers">
                                    <span data-feather="users"></span>
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
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="calendar"></span>
                                    Gestión de horarios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseDegree" href="#collapseDegree">
                                    <span data-feather="book-open"></span>
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
                                <a class="nav-link" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseDepartment" href="#collapseDepartment">
                                    <span data-feather="box"></span>
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
                                <a class="nav-link" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseUniversity" href="#collapseUniversity">
                                    <span data-feather="globe"></span>
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
                                    <span data-feather="archive"></span>
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
                                    <span data-feather="file-text"></span>
                                    PDA
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
                                    POD
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
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
