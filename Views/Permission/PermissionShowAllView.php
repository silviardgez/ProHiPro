<?php
include_once '../Functions/HavePermission.php';

class PermissionShowAllView
{
    private $permissions;
    private $itemsPerPage;
    private $currentPage;
    private $totalPermissions;
    private $totalPages;
    private $stringToSearch;

    function __construct($permissionData, $itemsPerPage = NULL, $currentPage = NULL, $totalPermissions = NULL, $stringToSearch = NULL)
    {
        $this->permissions = $permissionData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPermissions = $totalPermissions;
        $this->totalPages = ceil($totalPermissions / $itemsPerPage);
        $this->stringToSearch = $stringToSearch;
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
                <h1 class="h2" data-translate="Listado de asignación de permisos"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/PermissionController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/PermissionController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Permission", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../Controllers/PermissionController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Asignar permiso"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Rol"></label></th>
                        <th><label data-translate="Acción"></label></th>
                        <th><label data-translate="Funcionalidad"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->permissions)): ?>
                    <tbody>
                    <?php foreach ($this->permissions as $permission): ?>
                        <tr>
                            <td><?php echo $permission->getRole()->getName(); ?></td>
                            <td><?php echo $permission->getFuncAction()->getAction()->getName(); ?></td>
                            <td><?php echo $permission->getFuncAction()->getFunctionality()->getName(); ?></td>

                            <td class="row">
                                <?php if (HavePermission("Permission", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/PermissionController.php?action=show&id=<?php echo $permission->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Permission", "EDIT")) { ?>
                                    <a href="../Controllers/PermissionController.php?action=edit&id=<?php echo $permission->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Permission", "DELETE")) { ?>
                                    <a href="../Controllers/PermissionController.php?action=delete&id=<?php echo $permission->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún permiso">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalPermissions, "Permission"); ?>
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