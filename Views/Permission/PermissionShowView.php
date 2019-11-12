<?php
class PermissionShowView {
private $permission;

    function __construct($permissionData){
        $this->permission = $permissionData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2"><p data-translate="Asignación de permiso"></p></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/PermissionController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!empty($this->permission)): ?>
            <form>
                <div class="form-group">
                    <label for="name" data-translate="Rol"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->permission->getRole()->getName(); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Acción"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->permission->getFuncAction()->getAction()->getName(); ?>" readonly>

                </div>
                <div class="form-group">
                    <label for="description" data-translate="Funcionalidad"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->permission->getFuncAction()->getFunctionality()->getName() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El permiso no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>
