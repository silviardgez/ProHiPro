<?php

class TutorialSearchView
{
    private $teachers;
    private $spaces;

    function __construct($teachers,$spaces)
    {
        $this->teachers = $teachers;
        $this->spaces = $spaces;
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
                <h1 class="h2" data-translate="Búsqueda de asignaturas"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/TutorialController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="tutorialSearchForm" action='../Controllers/TutorialController.php?action=search' method='POST'
                  onsubmit="areTutorialSearchFieldsCorrect()">

                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <option data-translate="Introducir profesor responsable" value=""></option>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>">
                                <?php echo $teacher->getUser()->getName()." ". $teacher->getUser()->getSurname() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="space_id" data-translate="Espacio"></label>
                    <select class="form-control" id="space_id" name="space_id" ?>
                        <option data-translate="Introducir espacio" value=""></option>
                        <?php foreach ($this->spaces as $space): ?>
                            <option value="<?php echo $space->getId() ?>">
                                <?php echo $space->getName()." ". $space->getBuilding()->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="total-hours-div" class="form-group">
                    <label for="total_hours" data-translate="Número de horas"></label>
                    <input type="text" class="form-control" id="total_hours" name="total_hours"
                           data-translate="Introducir número de horas"
                           maxlength="3" oninput="checkTotalHoursEmptyTutorial(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
