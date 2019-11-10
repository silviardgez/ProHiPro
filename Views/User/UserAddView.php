<?php
class UserAddView {
private $searching;
private $action;

function __construct($searching){
    $this->searching = $searching;
    if($searching) {
        $this->action = "../Controllers/UserController.php?action=search";
    } else {
        $this->action = "../Controllers/UserController.php?action=add";
    }
    $this->render();
}
function render(){
?>
<head>
    <link rel="stylesheet" href="../CSS/default.css" />
    <link rel="stylesheet" href="../CSS/forms.css" />
    <script src="../JS/Validations/UserValidations.js"></script>
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <?php if(!$this->searching): ?>
            <h1 class="h2" data-translate="Añadir usuario"></h1>
            <?php else: ?>
            <h1 class="h2" data-translate="Búsqueda de usuarios"></h1>
            <?php endif; ?>
            <a class="btn btn-primary" role="button" href="../Controllers/UserController.php" data-translate="Volver"></a>
        </div>
        <form action='<?php echo $this->action ?>' method='POST'>
            <div class="form-group">
                <label for="login" data-translate="Login"></label>
                <input type="text" class="form-control" id="login" name="login" data-translate="Introducir nombre de usuario"
                required>
            </div>
            <?php if(!$this->searching): ?>
            <div class="form-group">
                <label for="password1" data-translate="Contraseña"></label>
                <input type="password" class="form-control" id="password1" name="password" data-translate="Introducir contraseña"
                required>
            </div>
            <div class="form-group">
                <label for="password2" data-translate="Confirmar contraseña"></label>
                <input type="password" class="form-control" id="password2" data-translate="Confirmar contraseña">
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="dni" data-translate="DNI"></label>
                <input type="text" class="form-control" id="dni" name="dni" data-translate="Introducir DNI">
            </div>
            <div class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre">
            </div>
            <div class="form-group">
                <label for="surname" data-translate="Apellido"></label>
                <input type="text" class="form-control" id="surname" name="surname" data-translate="Introducir apellido">
            </div>
            <div class="form-group">
                <label for="email" data-translate="Email"></label>
                <input type="email" class="form-control" id="email" name="email" data-translate="Introducir email">
            </div>
            <div class="form-group">
                <label for="address" data-translate="Dirección">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" data-translate="Introducir dirección">
            </div>
            <div class="form-group">
                <label for="telephone"  data-translate="Teléfono"></label>
                <input type="text" class="form-control" id="telephone" name="telephone" data-translate="Introducir teléfono">
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
<?php
    }
}
?>


