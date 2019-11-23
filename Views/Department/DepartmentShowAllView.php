<?php
include_once '../Functions/HavePermission.php';

class DepartmentShowAllView
{
    private $departments;
    private $itemsPerPage;
    private $currentPage;
    private $totalDepartments;
    private $totalPages;
    private $stringToSearch;

    function __construct($departmentsData, $itemsPerPage = NULL, $currentPage = NULL, $totalDepartments = NULL, $toSearch = NULL)
    {
        $this->departments = $departmentsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalDepartments = $totalDepartments;
        $this->totalPages = ceil($totalDepartments / $itemsPerPage);
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
                <h1 class="h2" data-translate="Listado de departamentos"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/DepartmentController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/DepartmentController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Department", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/DepartmentController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir departamento"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Código"></label></th>
                        <th><label data-translate="Profesor responsable"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->departments)): ?>
                    <tbody>
                    <?php foreach ($this->departments as $department): ?>
                        <tr>
                            <td><?php echo $department->getName() ;?></td>
                            <td><?php echo $department->getCode() ;?></td>
                            <td><?php echo $department->getTeacher()->getUser()->getName() . " " .
                                    $department->getTeacher()->getUser()->getSurname() ;?></td>
                            <td class="row">
                                <?php if (HavePermission("Department", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/DepartmentController.php?action=show&id=<?php echo $department->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Department", "EDIT")) { ?>
                                    <a href="../Controllers/DepartmentController.php?action=edit&id=<?php echo $department->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Department", "DELETE")) { ?>
                                    <a href="../Controllers/DepartmentController.php?action=delete&id=<?php echo $department->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún departamento">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalDepartments,
                    "Department") ?>

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
