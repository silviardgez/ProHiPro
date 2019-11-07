<?php
class RoleShowView {
	private $role;
    function __construct($roleData){
        $this->role = $roleData;
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
                <h1 class="h2">Role <?php echo $_REQUEST['IdRole'] ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/RoleController.php">Volver</a>
            </div>
            <?php if(!is_null($this->role)): ?>
            <form>
                <div class="form-group">
                    <label for="IdRole">IdRole</label>
                    <input type="text" class="form-control" id="IdRole" name="IdRole"
                           value="<?php echo $this->role->getIdRole() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->role->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->role->getDescription() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
            El role no existe.
            <?php endif; ?>
        </main>
        <?php
    }
}
?>