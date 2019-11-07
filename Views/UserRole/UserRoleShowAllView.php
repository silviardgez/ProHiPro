<?php
class UserRoleShowAllView {
private $userRoles;
private $roles;

function __construct($userRoleData, $roleData){
    $this->userRoles = $userRoleData;
    $this->roles = $roleData;
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
        <h1 class="h2"><p data-translate="Listado de Roles"></p></h1>
        <a class="btn btn-success" role="button" href="../Controllers/UserRoleController.php?action=add">
            <span data-feather="plus"></span><p data-translate="Añadir Rol a Usuario"></p></a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th><label data-translate="Usuario"></label></th>
                <th><label data-translate="Rol"></label></th>
				<th class="actions-row"><label data-translate="Acciones"></label></th>
            </tr>
            </thead>
            <?php if(!empty($this->userRoles)):?>
            <tbody>
                <?php foreach ($this->userRoles as $userRole): ?>
                <tr>
                    <td><?php echo $userRole->getLogin() ;?></td>

                    <?php foreach ($this->roles as $rol): ?>
                        <?php if($rol->getIdRole() == $userRole->getIdRole()): ?>
                            <td><?php echo $rol->getName() ;?></td>
                        <?php endif;?>
                    <?php endforeach;?>

                    <td class="row">
                        <a href="../Controllers/UserRoleController.php?action=show&IdUserRole=<?php echo $userRole->getIdUserRole()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/UserRoleController.php?action=edit&IdUserRole=<?php echo $userRole->getIdUserRole()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/UserRoleController.php?action=delete&IdUserRole=<?php echo $userRole->getIdUserRole()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p data-translate="No se ha obtenido ningún rol">. </p>
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