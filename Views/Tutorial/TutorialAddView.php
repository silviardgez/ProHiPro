<?php

class TutorialAddView
{
    private $teachers;
    private $spaces;

    function __construct($teachers, $spaces)
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
                <h1 class="h2" data-translate="Insertar asignatura"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/TutorialController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="tutorialForm" action='../Controllers/TutorialController.php?action=add' method='POST'
                  onsubmit="areTutorialFieldsCorrect()">

                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>">
                                <?php echo $teacher->getUser()->getName()." ". $teacher->getUser()->getSurname() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="space_id" data-translate="Espacio"></label>
                    <select class="form-control" id="space_id" name="space_id" ?>
                        <?php foreach ($this->spaces as $space): ?>
                            <option value="<?php echo $space->getId() ?>">
                                <?php echo $space->getName()." ". $space->getBuilding()->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="total-hours-div" class="form-group">
                    <label for="total_hours" data-translate="Número de horas"></label>
                    <input type="number" class="form-control" id="total_hours" name="total_hours"
                           data-translate="Introducir número de horas"
                           required maxlength="3" min="0" max="10" oninput="checkTotalHoursTutorial(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
