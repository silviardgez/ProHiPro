<?php


class PermissionShowAllView
{
    private $permissions;
    private $roles;
    private $funcActions;
    private $actions;
    private $functionalities;

    function __construct($permissionData, $roleData, $funcActionsData, $actionsData, $functionalitiesData){
        $this->permissions = $permissionData;
        $this->roles = $roleData;
        $this->funcActions = $funcActionsData;
        $this->actions = $actionsData;
        $this->functionalities = $functionalitiesData;
        $this->i=0;
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
                <h1 class="h2"><p data-translate="Listado de Permisos"></p></h1>
                <a class="btn btn-success" role="button" href="../Controllers/PermissionController.php?action=add">
                    <span data-feather="plus"></span><p data-translate="Añadir Permiso"></p></a>
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
                    <p data-translate="No se ha obtenido ningun permiso">. </p>
                <?php endif; ?>
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
