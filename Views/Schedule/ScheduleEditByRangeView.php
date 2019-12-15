<?php

class ScheduleEditByRangeView
{
    private $spaces;
    private $teachers;
    private $subjectGroups;
    private $subject;

    function __construct($teachers, $spaces, $subjectGroups)
    {
        $this->teachers = $teachers;
        $this->spaces = $spaces;
        $this->subjectGroups = $subjectGroups;
        $this->subject = $_REQUEST["subject"];
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/ScheduleValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar por rango"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject ?>"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="teacherForm" action='../Controllers/ScheduleController.php?subject=<?php echo $this->subject ?>&action=editByRange' method='POST'
                  onsubmit="areScheduleFieldsCorrect()">
                <div class="form-group">
                    <label for="subject_group_id" data-translate="Grupo"></label>
                    <select class="form-control" id="subject_group_id" name="subject_group_id">
                        <?php foreach ($this->subjectGroups as $group): ?>
                            <option value="<?php echo $group->getId() ?>">
                                <?php echo $group->getSubject()->getAcronym()."_". $group->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="space_id" data-translate="Aula"></label>
                    <select class="form-control" id="space_id" name="space_id">
                        <option data-translate="Introducir aula" value=""></option>
                        <?php foreach ($this->spaces as $space): ?>
                            <option value="<?php echo $space->getId() ?>">
                                <?php echo $space->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id">
                        <option data-translate="Introducir profesor" value=""></option>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>">
                                <?php echo $teacher->getUser()->getName() . " " . $teacher->getUser()->getSurname() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="start-day-div" class="form-group">
                    <label for="start_day" data-translate="Día de inicio"></label>
                    <input type="date" class="form-control" id="start_day" name="start_day"
                           required oninput="checkStartDayTeacher(this)">
                </div>
                <div id="end-day-div" class="form-group">
                    <label for="end_day" data-translate="Día de fin"></label>
                    <input type="date" class="form-control" id="end_day" name="end_day"
                           required oninput="checkEndDayTeacher(this)">
                </div>
                <div id="start-hour-div" class="form-group">
                    <label for="start_hour" data-translate="Hora de inicio"></label>
                    <input type="time" class="form-control" id="start_hour" name="start_hour"
                           oninput="checkStartHourTeacher(this)">
                </div>
                <div id="end-hour-div" class="form-group">
                    <label for="end_hour" data-translate="Hora de fin"></label>
                    <input type="time" class="form-control" id="end_hour" name="end_hour"
                           oninput="checkEndHourTeacher(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
