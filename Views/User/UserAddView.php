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
    <script src="../Validations.js"></script>
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2" data-translate="Añadir usuario"></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/UserController.php" data-translate="Volver"></a>
        </div>
        <form id="userForm" name = "ADD" action='../Controllers/UserController.php?action=add' method='POST' onsubmit="return checkAddUser()">
            <div class="form-group">
                <label for="login" data-translate="Login"></label>
                <input type="text" class="form-control" id="login" name="login" max-length="9" data-translate="Introducir nombre de usuario"
                required onblur="checkEmpty(this) && withOutWhiteSpaces(this) && checkLength(this,'9') && checkText(this,'9')">
            </div>
            <div class="form-group">
                <label for="password1" data-translate="Contraseña"></label>
                <input type="password" class="form-control" id="password1" name="password" max-length="20" data-translate="Introducir contraseña"
                required onblur="checkEmpty(this) && withOutWhiteSpaces(this) && checkLength(this,'20') && checkText(this,'20')" >
            </div>
            <div class="form-group">
                <label for="password2" data-translate="Confirmar contraseña"></label>
                <input type="password" class="form-control" id="password2" max-length="20" data-translate="Confirmar contraseña"
                       required onblur="checkEmpty(this) && withOutWhiteSpaces(this) && checkLength(this,'20') && checkText(this,'20')">
            </div>
            <div class="form-group">
                <label for="dni" data-translate="DNI"></label>
                <input type="text" class="form-control" id="dni" name="dni" max-length="9" data-translate="Introducir DNI"
                required onblur="checkEmpty(this) && withOutWhiteSpaces(this) && checkLength(this,'9') && checkText(this,'9') && checkDni(this)">
            </div>
            <div class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name" max-length="30" data-translate="Introducir nombre"
                       required onblur="checkEmpty(this) && checkLength(this,'30') && checkText(this,'30') && checkAlphabetical(this,30)">
            </div>
            <div class="form-group">
                <label for="surname" data-translate="Apellido"></label>
                <input type="text" class="form-control" id="surname" name="surname" max-length="50" data-translate="Introducir apellido"
                required onblur="checkEmpty(this) && checkLength(this,'50') && checkText(this,'50') && checkAlphabetical(this,50)">
            </div>
            <div class="form-group">
                <label for="email" data-translate="Email"></label>
                <input type="email" class="form-control" id="email" name="email" max-length="40" data-translate="Introducir email"
                       required onblur="checkEmpty(this) && checkLength(this,'40') && checkText(this,'40') && checkEmail(this)">
            </div>
            <div class="form-group">
                <label for="address" data-translate="Dirección">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" max-length="60" data-translate="Introducir dirección"
                       required onblur="checkEmpty(this) && withOutWhiteSpaces(this) && checkLength(this,'60') && checkText(this,'60')">
            </div>
            <div class="form-group">
                <label for="telephone"  data-translate="Teléfono"></label>
                <input type="text" class="form-control" id="telephone" name="telephone" max-length="11" data-translate="Introducir teléfono"
                required onblur="checkEmpty(this) && checkLength(this,'11') && checkTelf(this)">
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
    <div id="capaVentana" style="visibility: hidden;position:fixed;position: fixed;padding: 0px;right: 0%;top:40%;z-index:2">
        <table  width="250px" style="border:1px solid red;padding:0px;">
            <tr>
                <td colspan="2" style="background-color:red" width="250px">
                    <font style="font-size:24px;color:white">ALERTA</font>
                </td>

            </tr>
            <tr>
                <td colspan="2" style="background-color:white;" >
                    <div id="miDiv" style="color:black;"></div>
                </td>
            </tr>
            <tr style="background-color:white">
                <td >
                    <form name="formError">
                        <button type="button"  name="bAceptar"  value="Aceptar" onclick="cerrarVentana()" ><img src="../Views/icon/confirmar.png" height="32" width="32"  /></button>
                    </form>
                </td>
            </tr>

        </table>
    </div>

    <div id="capaFondo1" style="visibility:hidden;position: fixed;padding: 0px;width: 100%;height: 100%;top:0;left:0;z-index:1;background-color: rgba(1,,1,1,0.5)"></div>

<?php
    }
}
?>