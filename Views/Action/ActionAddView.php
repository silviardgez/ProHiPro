<?php
class ActionAddView {

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
            <h1 class="h2" data-translate="Insertar acción"></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/ActionController.php" data-translate="Volver"></a>
        </div>
        <form id="actionForm" name = "ADD" action='../Controllers/ActionController.php?action=add' method='POST' onsubmit="return checkAddNameDescription()">
            <div class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre" required onblur="checkEmpty(this)">
            </div>
            <div class="form-group">
                <label for="description" data-translate="Descripción"></label>
                <input type="text" class="form-control" id="description" name="description" data-translate="Introducir descripción" required onblur="checkEmpty(this)">
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
