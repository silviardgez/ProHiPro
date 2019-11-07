<?php
class RoleAddView {

function __construct(){
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
            <h1 class="h2">Insertar role</h1>
            <a class="btn btn-primary" role="button" href="../Controllers/RoleController.php">Volver</a>
        </div>
        <form action='../Controllers/RoleController.php?action=add' method='POST'>
            <div class="form-group">
                <label for="IdRole">IdRole</label>
                <input type="text" class="form-control" id="IdRole" name="IdRole" placeholder="Introducir IdRole">
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Introducir nombre">
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Introducir descripción">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </main>
<?php
    }
}
?>


