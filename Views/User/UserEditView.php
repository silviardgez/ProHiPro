<?php
class UserEditView {
    private $user;
    function __construct($userData){
        $this->user = $userData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../css/default.css" />
            <link rel="stylesheet" href="../css/add_style.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2">Usuario <?php echo $this->user->getLogin() ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UserController.php">Volver</a>
            </div>
            <form action='../Controllers/UserController.php?action=edit' method='POST'>
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" id="login" name="login"
                           value="<?php echo $this->user->getLogin() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="password1">Contraseña</label>
                    <input type="password" class="form-control" id="password1" name="password"
                           value="<?php echo $this->user->getPassword() ?>">
                </div>
                <div class="form-group">
                    <label for="password2">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="password2"
                           value="<?php echo $this->user->getPassword() ?>">
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni"
                           value="<?php echo $this->user->getDni() ?>">
                </div>
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->user->getName() ?>">
                </div>
                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input type="text" class="form-control" id="surname" name="surname"
                           value="<?php echo $this->user->getSurname() ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?php echo $this->user->getEmail() ?>">
                </div>
                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="<?php echo $this->user->getAddress() ?>">
                </div>
                <div class="form-group">
                    <label for="telephone">Teléfono</label>
                    <input type="text" class="form-control" id="telephone" name="telephone"
                           value="<?php echo $this->user->getTelephone() ?>">
                </div>
                <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </main>
        <?php
    }
}
?>