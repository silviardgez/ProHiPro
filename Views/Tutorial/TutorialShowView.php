<?php

class TutorialShowView
{
    private $tutorial;

    function __construct($tutorial)
    {
        $this->tutorial = $tutorial;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/TutorialValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Tutoría '%<?php echo $this->tutorial->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/TutorialController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="tutorialForm" method='POST'>

                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <input type="text" class="form-control" id="teacher_id" name="teacher_id" readonly
                           value="<?php echo $this->tutorial->getTeacher()->getUser()->getName()." ".
                               $this->tutorial->getTeacher()->getUser()->getSurname() ?>">
                </div>

                <div class="form-group">
                    <label for="space_id" data-translate="Espacio"></label>
                    <input type="text" class="form-control" id="space_id" name="space_id" readonly
                           value="<?php echo $this->tutorial->getSpace()->getName()." ".
                               $this->tutorial->getSpace()->getBuilding()->getName() ?>">
                </div>

                <div id="total-hours-div" class="form-group">
                    <label for="total_hours" data-translate="Número de horas"></label>
                    <input type="number" class="form-control" id="total_hours" name="total_hours"
                           value="<?php echo $this->tutorial->getTotalHours() ?>" readonly>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
