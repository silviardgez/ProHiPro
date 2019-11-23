<?php
include_once '../Functions/HavePermission.php';

class TeacherShowAllView
{
    private $teachers;
    private $itemsPerPage;
    private $currentPage;
    private $totalTeachers;
    private $totalPages;
    private $stringToSearch;

    function __construct($teachersData, $itemsPerPage = NULL, $currentPage = NULL, $totalTeachers = NULL, $toSearch = NULL)
    {
        $this->teachers = $teachersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalTeachers = $totalTeachers;
        $this->totalPages = ceil($totalTeachers / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/table.css"/>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de profesores"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/TeacherController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/TeacherController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Teacher", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/TeacherController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir profesor"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="DNI"></label></th>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Nombre de usuario"></label></th>
                        <th><label data-translate="Dedicación"></label></th>
                        <th><label data-translate="Despacho"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->teachers)): ?>
                    <tbody>
                    <?php foreach ($this->teachers as $teacher): ?>
                        <tr>
                            <td><?php echo $teacher->getUser()->getDNI() ;?></td>
                            <td><?php echo $teacher->getUser()->getName() . " " . $teacher->getUser()->getSurname() ;?></td>
                            <td><?php echo $teacher->getUser()->getId() ;?></td>
                            <td><?php echo $teacher->getDedication() ;?></td>
                            <?php if(!empty($teacher->getSpace())): ?>
                            <td><?php echo $teacher->getSpace()->getName() ;?></td>
                            <?php else: ?>
                            <td data-translate="No asignado"></td>
                            <?php endif; ?>
                            <td class="row">
                                <?php if (HavePermission("Teacher", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/TeacherController.php?action=show&id=<?php echo $teacher->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Teacher", "EDIT")) { ?>
                                    <a href="../Controllers/TeacherController.php?action=edit&id=<?php echo $teacher->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Teacher", "DELETE")) { ?>
                                    <a href="../Controllers/TeacherController.php?action=delete&id=<?php echo $teacher->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún profesor">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalTeachers,
                    "Teacher") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <?php
    }
}

?>
