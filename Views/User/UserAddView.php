<?php
class UserAddView {

function __construct(){
    $this->render();
}
function render(){
?>
<head>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/add_style.css" />
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2">Insertar usuario</h1>
            <a class="btn btn-primary" role="button" href="../Controllers/UserController.php">Volver</a>
        </div>
        <form action='../Controllers/UserController.php?action=add' method='POST'>
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Introducir login">
            </div>
            <div class="form-group">
                <label for="password1">Contraseña</label>
                <input type="password" class="form-control" id="password1" name="password" placeholder="Introducir contraseña">
            </div>
            <div class="form-group">
                <label for="password2">Confirmar contraseña</label>
                <input type="password" class="form-control" id="password2" placeholder="Confirmar contraseña">
            </div>
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" placeholder="Introducir DNI">
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Introducir nombre">
            </div>
            <div class="form-group">
                <label for="surname">Apellido</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Introducir apellido">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Introducir email">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Introducir dirección">
            </div>
            <div class="form-group">
                <label for="telephone">Teléfono</label>
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Introducir teléfono">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </main>
<?php
    }
}
?>


