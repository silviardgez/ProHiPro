<?php
class PermissionAddView {
    private $roles;
    private $funcActions;

function __construct($rolesData, $funcActionData){
    $this->roles = $rolesData;
    $this->funcActions = $funcActionData;
    $this->render();
}
function render(){
?>
<head>
    <link rel="stylesheet" href="../CSS/default.css" />
    <link rel="stylesheet" href="../CSS/forms.css" />
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2" data-translate="Insertar asignación de permiso"></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/PermissionController.php"><p data-translate="Volver"></p></a>
        </div>
        <form action='../Controllers/PermissionController.php?action=add' method='POST'>
            <div class="form-group">
                <label for="name" data-translate="Rol"></label>
                <select class="form-control" id="role_id" name="role_id">
                    <?php foreach ($this->roles as $rol): ?>
                        <option value="<?php echo $rol->getId() ?>"><?php echo $rol->getName() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="description" data-translate="Permiso"></label>
                <select class="form-control" id="func_action_id" name="func_action_id"?>
                    <?php foreach ($this->funcActions as $funcAction): ?>
                        <option value="<?php echo $funcAction->getId() ?>">
                            <?php echo $funcAction->getAction()->getName()." - ". $funcAction->getFunctionality()->getName(); ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
<?php
    }
}
?>

