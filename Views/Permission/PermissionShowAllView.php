<?php
class PermissionShowAllView
{
    private $permissions;
    private $roles;
    private $funcActions;
    private $actions;
    private $functionalities;
    private $itemsPerPage;
    private $currentPage;
    private $totalPermissions;
    private $totalPages;
    private $stringToSearch;

    function __construct($permissionData, $roleData, $funcActionsData, $actionsData, $functionalitiesData,
                         $itemsPerPage, $currentPage, $totalPermissions, $stringToSearch){
        $this->permissions = $permissionData;
        $this->roles = $roleData;
        $this->funcActions = $funcActionsData;
        $this->actions = $actionsData;
        $this->functionalities = $functionalitiesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPermissions = $totalPermissions;
        $this->totalPages = ceil($totalPermissions/$itemsPerPage);
        $this->stringToSearch = $stringToSearch;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/table.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de Permisos"></h1>
                <?php if ($this->stringToSearch!=null && $this->stringToSearch!=''): ?>
                <?php echo "<a class=\"btn btn-primary\" role=\"button\" href=\"../Controllers/PermissionController.php\"><p data-translate=\"Volver\"></p></a>";?>
                <?php else:?>
                <?php echo "<a class=\"btn btn-success\" role=\"button\" href=\"../Controllers/PermissionController.php?action=add\">
                    <span data-feather=\"plus\"></span><p data-translate=\"Añadir Permiso\"></p></a>";?>
                <?php endif;?>
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
                    <?php if(!empty($this->permissions)):?>
                    <tbody>
                    <?php foreach ($this->permissions as $permission): ?>
                        <tr>
                            <?php foreach ($this->roles as $rol): ?>
                                <?php if ($rol->getIdRole() == $permission->getIdRole()): ?>
                                    <td><?php echo $rol->getName(); ?></td>
                                <?php endif;?>
                            <?php endforeach;?>

                            <?php foreach($this->funcActions as $funcAction): ?>
                                <?php foreach($this->actions as $action) : ?>
                                    <?php if ($permission->getIdFuncAction() == $funcAction->getIdFuncAction()):?>
                                        <?php if($action->getIdAction() == $funcAction->getIdAction()):?>
                                            <td><?php echo $action->getName() ;?></td>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endforeach;?>

                            <?php foreach($this->funcActions as $funcAction): ?>
                                <?php foreach($this->functionalities as $func) : ?>
                                    <?php if ($permission->getIdFuncAction() == $funcAction->getIdFuncAction()):?>
                                        <?php if($func->getIdFunctionality() == $funcAction->getIdFunctionality()):?>
                                            <td><?php echo $func->getName() ;?></td>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endforeach;?>

                            <td class="row">
                                <a href="../Controllers/PermissionController.php?action=show&IdPermission=<?php echo $permission->getIdPermission()?>">
                                    <span data-feather="eye"></span></a>
                                <a href="../Controllers/PermissionController.php?action=edit&IdPermission=<?php echo $permission->getIdPermission()?>">
                                    <span data-feather="edit"></span></a>
                                <a href="../Controllers/PermissionController.php?action=delete&IdPermission=<?php echo $permission->getIdPermission()?>">
                                    <span data-feather="trash-2"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún permiso">. </p>
                <?php endif; ?>

                <div class="row">
                    <!-- Search -->
                    <?php if($this->totalPermissions > 0): ?>
                        <a class="btn btn-primary button-specific-search" role="button"
                           href="../Controllers/PermissionController.php?action=search">
                            <span data-feather="search"></span><p class="btn-show-view" data-translate="Búsqueda específica"></p></a>

                        <!-- Pagination -->
                        <label class="label-pagination" data-translate="Permisos por página"></label>
                        <select class="form-control items-page" id="items-page-select"
                                onchange="selectChange(this, 'Permission')">
                            <option value="5" <?php if ($this->itemsPerPage == 5) echo "selected" ?>>5</option>
                            <option value="10" <?php if ($this->itemsPerPage == 10) echo "selected" ?>>10</option>
                            <option value="15" <?php if ($this->itemsPerPage == 15) echo "selected" ?>>15</option>
                            <option value="20" <?php if ($this->itemsPerPage == 20) echo "selected" ?>>20</option>
                        </select>
                        <?php if ($this->totalPages > 1): ?>
                            <nav aria-label="...">
                                <ul class="pagination">
                                    <?php if ($this->currentPage == 1): ?>
                                <li class="page-item disabled">
                                <?php else: ?>
                                    <li class="page-item">
                                        <?php endif; ?>
                                        <a class="page-link" href="../Controllers/PermissionController.php?currentPage=<?php echo $this->currentPage-1?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $this->totalPages; $i++): ?>
                                        <?php if ($this->currentPage == $i): ?>
                                            <li class="page-item active">
                                        <?php else: ?>
                                            <li class="page-item">
                                        <?php endif; ?>
                                        <a class="page-link"
                                           href="../Controllers/PermissionController.php?currentPage=<?php echo $i ?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                                            <?php echo $i?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($this->currentPage == $this->totalPages): ?>
                                    <li class="page-item disabled">
                                        <?php else: ?>
                                    <li class="page-item">
                                        <?php endif; ?>
                                        <a class="page-link" href="../Controllers/PermissionController.php?currentPage=<?php echo $this->currentPage+1?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
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

<script>
    translatePage(getCookie("language-selected"));
</script>