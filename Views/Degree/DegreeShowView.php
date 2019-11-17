<?php

class DegreeShowView
{
    private $degree;

    function __construct($degreeData)
    {
        $this->degree = $degreeData;
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-degree pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Centro '%<?php echo $this->degree->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DegreeController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/DegreeController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->degree->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="center_id" data-translate="Centro"></label>
                    <input type="text" class="form-control" id="center_id" name="center_id"
                           data-translate="Introducir universidad"
                           value="<?php echo $this->degree->getCenter()->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id" data-translate="Responsable"
                           value="<?php echo $this->degree->getUser()->getName() . " " . $this->degree->getUser()->getSurname() ?>"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="capacity" data-translate="Capacidad"></label>
                    <input type="text" class="form-control" id="capacity" name="capacity" data-translate="Capacidad"
                           value="<?php echo $this->degree->getCapacity() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="credits" data-translate="Créditos"></label>
                    <input type="text" class="form-control" id="credits" name="credits" data-translate="Créditos"
                           value="<?php echo $this->degree->getCredits() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->degree->getDescription() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}

?>
