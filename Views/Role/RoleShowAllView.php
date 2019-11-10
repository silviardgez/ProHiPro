<?php
class RoleShowAllView {
private $roles;

function __construct($rolesData){
    $this->roles = $rolesData;
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
        <h1 class="h2" data-translate="Listado de Roles"></h1>
        <a class="btn btn-success" role="button" href="../Controllers/RoleController.php?action=add">
            <span data-feather="plus"></span> <p data-translate="Añadir rol"></p></a>
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
            <?php if(!empty($this->roles)):?>
            <tbody>
                <?php foreach ($this->roles as $role): ?>
                <tr>
                    <td><?php echo $role->getIdRole() ?></td>
                    <td><?php echo $role->getName() ?></td>
                    <td><?php echo $role->getDescription() ?></td>
                    <td class="row">
                        <a href="../Controllers/RoleController.php?action=show&IdRole=<?php echo $role->getIdRole()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/RoleController.php?action=edit&IdRole=<?php echo $role->getIdRole()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/RoleController.php?action=delete&IdRole=<?php echo $role->getIdRole()?>">
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