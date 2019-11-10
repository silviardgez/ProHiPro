<?php
class RoleEditView {
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
                <h1 class="h2" data-translate="Rol"> <?php echo $this->role->getIdRole() ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/RoleController.php" data-translate="Volver"></a>
            </div>
            <form action='../Controllers/RoleController.php?action=edit' method='POST'>
                <div class="form-group">
                    <label for="IdRole" data-translate="Id rol"></label>
                    <input type="text" class="form-control" id="IdRole" name="IdRole"
                           value="<?php echo $this->role->getIdRole() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->role->getName() ?>">
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->role->getDescription() ?>">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>