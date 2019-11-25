<?php
class UserAddView {
function __construct(){
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
            <h1 class="h2" data-translate="Añadir usuario"></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/UserController.php" data-translate="Volver"></a>
        </div>
        <form id="userForm" action='../Controllers/UserController.php?action=add' method='POST' onsubmit="return areUserFieldsCorrect()">
            <div id="login-div" class="form-group">
                <label for="login" data-translate="Login"></label>
                <input type="text" class="form-control" id="login" name="login" maxlength="9" data-translate="Introducir nombre de usuario"
                required oninput="checkLoginUser(this);">
            </div>
            <div id="password-div" class="form-group">
                <label for="password1" data-translate="Contraseña"></label>
                <input type="password" class="form-control" id="password1" name="password" maxlength="20" data-translate="Introducir contraseña"
                required oninput="checkPasswordUser(this);" >
            </div>
            <div id="confirm-password-div" class="form-group">
                <label for="password2" data-translate="Confirmar contraseña"></label>
                <input type="password" class="form-control" id="password2" maxlength="20" data-translate="Confirmar contraseña"
                       required oninput="checkConfirmPasswordUser(this);">
            </div>
            <div id="dni-div" class="form-group">
                <label for="dni" data-translate="DNI"></label>
                <input type="text" class="form-control" id="dni" name="dni" maxlength="9" data-translate="Introducir DNI"
                required oninput="checkDniUser(this);">
            </div>
            <div id="name-div" class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name" maxlength="30" data-translate="Introducir nombre"
                       required oninput="checkNameUser(this);">
            </div>
            <div id="surname-div" class="form-group">
                <label for="surname" data-translate="Apellido"></label>
                <input type="text" class="form-control" id="surname" name="surname" maxlength="50" data-translate="Introducir apellido"
                required oninput="checkSurnameUser(this);">
            </div>
            <div id="email-div" class="form-group">
                <label for="email" data-translate="Email"></label>
                <input type="email" class="form-control" id="email" name="email" maxlength="40" data-translate="Introducir email"
                       required oninput="checkEmailUser(this);">
            </div>
            <div id="address-div" class="form-group">
                <label for="address" data-translate="Dirección">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" maxlength="60" data-translate="Introducir dirección"
                       required oninput="checkAddressUser(this);">
            </div>
            <div id="telephone-div" class="form-group">
                <label for="telephone"  data-translate="Teléfono"></label>
                <input type="text" class="form-control" id="telephone" name="telephone" maxlength="11" data-translate="Introducir teléfono"
                required oninput="checkTelephoneUser(this);">
            </div>
            <button id="btn-add-user" name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>

<?php
    }
}
?>
