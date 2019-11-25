<?php

class TutorialEditView
{
    private $tutorial;
    private $teachers;
    private $spaces;

    function __construct($tutorial, $teachers, $spaces)
    {
        $this->tutorial = $tutorial;
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
                <h1 class="h2" data-translate="Editar tutoría '%<?php echo $this->tutorial->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/TutorialController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="tutorialForm" action='../Controllers/TutorialController.php?action=edit&id=<?php echo $this->tutorial->getId() ?>'
                  method='POST' onsubmit="areTutorialFieldsCorrect()">

                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>"
                                <?php if($teacher->getId() == $this->tutorial->getTeacher()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $teacher->getUser()->getName()." ". $teacher->getUser()->getSurname() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="space_id" data-translate="Espacio"></label>
                    <select class="form-control" id="space_id" name="space_id" ?>
                        <?php foreach ($this->spaces as $space): ?>
                            <option value="<?php echo $space->getId() ?>"
                                <?php if($space->getId() == $this->tutorial->getSpace()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $space->getName()." ". $space->getBuilding()->getname() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="total-hours-div" class="form-group">
                    <label for="total_hours" data-translate="Horas"></label>
                    <input type="number" class="form-control" id="total_hours" name="total_hours"
                           data-translate="Introducir número de horas"
                           required maxlength="5" min="0" max="10" oninput="checkTotalHoursTutorial(this)"
                           value="<?php echo $this->tutorial->getTotalHours() ?>">
                </div>

                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
