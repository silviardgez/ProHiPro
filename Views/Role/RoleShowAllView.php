<?php
include_once '../Functions/HavePermission.php';

class RoleShowAllView
{
    private $roles;
    private $itemsPerPage;
    private $currentPage;
    private $totalRoles;
    private $totalPages;
    private $stringToSearch;

    function __construct($rolesData, $itemsPerPage = NULL, $currentPage = NULL, $totalRoles = NULL, $toSearch = NULL)
    {
        $this->roles = $rolesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalRoles = $totalRoles;
        $this->totalPages = ceil($totalRoles / $itemsPerPage);
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
                <h1 class="h2" data-translate="Listado de roles"></h1>
                <!-- Search -->
                <form class="row" action='../Controllers/RoleController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/RoleController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Role", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/RoleController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir rol"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th data-translate="Id rol"></th>
                        <th data-translate="Nombre"></th>
                        <th data-translate="Descripción"></th>
                        <th class="actions-row" data-translate="Acciones"></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->roles)): ?>
                    <tbody>
                    <?php foreach ($this->roles as $role): ?>
                        <tr>
                            <td><?php echo $role->getId() ?></td>
                            <td><?php echo $role->getName() ?></td>
                            <td><?php echo $role->getDescription() ?></td>
                            <td class="row">
                                <? if (HavePermission("Role", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/RoleController.php?action=show&id=<?php echo $role->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <? }
                                if (HavePermission("Role", "EDIT")) { ?>
                                    <a href="../Controllers/RoleController.php?action=edit&id=<?php echo $role->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <? }
                                if (HavePermission("Role", "DELETE")) { ?>
                                    <a href="../Controllers/RoleController.php?action=delete&id=<?php echo $role->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <? } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún rol">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalRoles,
                    "Role") ?>

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