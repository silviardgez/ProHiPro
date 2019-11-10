<?php
class UserSearchView {
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
                <h1 class="h2" data-translate="Búsqueda de usuarios"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UserController.php" data-translate="Volver"></a>
            </div>
            <form id="userSearchForm" action='../Controllers/UserController.php?action=search' method='POST'  onsubmit="return areUserSearchFieldsCorrect()">
                <div id="login-div" class="form-group">
                    <label for="login" data-translate="Login"></label>
                    <input type="text" class="form-control" id="login" name="login" max-length="9" data-translate="Introducir nombre de usuario"
                           oninput="checkLoginEmptyUser(this);">
                </div>
                <div id="dni-div" class="form-group">
                    <label for="dni" data-translate="DNI"></label>
                    <input type="text" class="form-control" id="dni" name="dni"  max-length="9" data-translate="Introducir DNI"
                           oninput="checkDniEmptyUser(this);">
                </div>
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"  max-length="30" data-translate="Introducir nombre"
                           oninput="checkNameEmptyUser(this);">
                </div>
                <div id="surname-div" class="form-group">
                    <label for="surname" data-translate="Apellido"></label>
                    <input type="text" class="form-control" id="surname" name="surname" max-length="50" data-translate="Introducir apellido"
                           oninput="checkSurnameEmptyUser(this);">
                </div>
                <div id="email-div" class="form-group">
                    <label for="email" data-translate="Email"></label>
                    <input type="email" class="form-control" id="email" name="email" max-length="40" data-translate="Introducir email"
                           oninput="checkEmailEmptyUser(this);">
                </div>
                <div id="address-div" class="form-group">
                    <label for="address" data-translate="Dirección">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" max-length="60" data-translate="Introducir dirección"
                           oninput="checkAddressEmptyUser(this);">
                </div>
                <div id="telephone-div" class="form-group">
                    <label for="telephone"  data-translate="Teléfono"></label>
                    <input type="text" class="form-control" id="telephone" name="telephone" max-length="11" data-translate="Introducir teléfono"
                           oninput="checkTelephoneEmptyUser(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
