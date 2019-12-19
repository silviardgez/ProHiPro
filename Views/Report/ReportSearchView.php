<?php
class ReportSearchView {
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
                <h1 class="h2" data-translate="Generación de informes"></h1>
            </div>
            <form id="userSearchForm" action='../Controllers/ReportController.php?action=search' method='POST'>
                <div id="login-div" class="form-group">
                    <label for="login" data-translate="Seleccionar entidad""></label>
                    <select class="form-control" id="entity" name="entity">
                        <option value="center" data-translate="Centro"></option>
                        <option value="degree" data-translate="Titulación"></option>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>
