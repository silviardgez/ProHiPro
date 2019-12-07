<?php


class PdaReaderShowAllView
{
    function __construct()
    {
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Insertar PDA"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/PDAController.php"
                   data-translate="Volver"></a>
            </div>
            <form id="actionForm" name="ADD" action='../Controllers/PDAController.php?action=add' method='POST'
                  enctype="multipart/form-data">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="PDA"></label>
                    <input type="file" name="file" id="file" class="form-control" data-translate="Insertar PDA"
                           accept=".pdf" required>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>


        <?php
    }

}

?>