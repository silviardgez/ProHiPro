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
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/UserValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Editar usuario %<?php echo $this->user->getLogin() ?>%"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UserController.php" data-translate="Volver"></a>
            </div>
            <form id="userEditForm" action='../Controllers/UserController.php?action=edit' method='POST' onsubmit="return areUserEditFieldsCorrect()">
                <div id="login-div" class="form-group">
                    <label for="login" data-translate="Login"></label>
                    <input type="text" class="form-control" id="login" name="login" max-length="9"
                           value="<?php echo $this->user->getLogin() ?>" readonly
                           required oninput="checkLoginUser(this);" required>
                </div>
                <div id="password-div" class="form-group">
                    <label for="password1" data-translate="Contraseña"></label>
                    <input type="password" class="form-control" id="password1" name="password" max-length="20"
                           oninput="checkPasswordEmptyUser(this);">
                </div>
                <div id="confirm-password-div" class="form-group">
                    <label for="password2" data-translate="Confirmar contraseña"></label>
                    <input type="password" class="form-control" id="password2" max-length="20"
                           oninput="checkConfirmPasswordEmptyUser(this);">
                </div>
                <div id="dni-div" class="form-group">
                    <label for="dni" data-translate="DNI"></label>
                    <input type="text" class="form-control" id="dni" name="dni" max-length="9"
                           value="<?php echo $this->user->getDni() ?>"
                           required oninput="checkDniUser(this);">
                </div>
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" max-length="30"
                           value="<?php echo $this->user->getName() ?>"
                           required oninput="checkNameUser(this);">
                </div>
                <div id="surname-div" class="form-group">
                    <label for="surname" data-translate="Apellido"></label>
                    <input type="text" class="form-control" id="surname" name="surname" max-length="50"
                           value="<?php echo $this->user->getSurname() ?>"
                           required oninput="checkSurnameUser(this);">
                </div>
                <div id="email-div" class="form-group">
                    <label for="email" data-translate="Email"></label>
                    <input type="email" class="form-control" id="email" name="email" max-length="40"
                           value="<?php echo $this->user->getEmail() ?>"
                           required oninput="checkEmailUser(this);">
                </div>
                <div id="address-div" class="form-group">
                    <label for="address" data-translate="Dirección"></label>
                    <input type="text" class="form-control" id="address" name="address" max-length="60"
                           value="<?php echo $this->user->getAddress() ?>"
                           required oninput="checkAddressUser(this);">
                </div>
                <div id="telephone-div" class="form-group">
                    <label for="telephone" data-translate="Teléfono"></label>
                    <input type="text" class="form-control" id="telephone" name="telephone" max-length="11"
                           value="<?php echo $this->user->getTelephone() ?>"
                           required oninput="checkTelephoneUser(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>