<?php
include_once '../Functions/HavePermission.php';

class GroupShowAllView
{
    private $groups;
    private $itemsPerPage;
    private $currentPage;
    private $totalGroups;
    private $totalPages;
    private $stringToSearch;
    private $searching;
    private $permission;

    function __construct($groupsData, $itemsPerPage = NULL, $currentPage = NULL, $totalGroups = NULL, $toSearch = NULL,$searching=false,$permission=false)
    {
        $this->groups = $groupsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalGroups = $totalGroups;
        $this->totalPages = ceil($totalGroups / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->permission=$permission;
        $this->searching=$searching;
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
                <h1 class="h2" data-translate="Listado de grupos"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/GroupController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/GroupController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                if (HavePermission("SubjectGroup", "ADD")): ?>
                    <a class="btn btn-success" role="button" href="../Controllers/GroupController.php?action=add">
                        <span data-feather="plus"></span>
                        <p data-translate="Añadir grupo"></p>
                    </a>
                <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Asignatura"></label></th>
                        <th><label data-translate="Capacidad"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->groups)): ?>
                    <tbody>
                    <?php foreach ($this->groups as $group): ?>
                        <tr>
                            <td><?php echo $group->getName(); ?></td>
                            <td><?php echo $group->getSubject()->getContent(); ?></td>
                            <td><?php echo $group->getCapacity(); ?></td>
                            <td class="row">
                                <?php if (HavePermission("SubjectGroup", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/GroupController.php?action=show&id=<?php echo $group->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("SubjectGroup", "EDIT")) { ?>
                                    <a href="../Controllers/GroupController.php?action=edit&id=<?php echo $group->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("SubjectGroup", "DELETE")) { ?>
                                    <a href="../Controllers/GroupController.php?action=delete&id=<?php echo $group->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún grupo">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalGroups,
                    "Group") ?>

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
