<?php

class ScheduleShowView
{
    private $schedule;
    private $subject;

    function __construct($schedule)
    {
        $this->schedule = $schedule;
        $this->subject = $_REQUEST["subject"];
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
                <h1 class="h2" data-translate="Horario '%<?php echo $this->schedule->getId()?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject ?>"><p
                        data-translate="Volver"></p></a>
            </div>
                <div class="form-group">
                    <label for="subject_group_id" data-translate="Grupo"></label>
                    <input type="text" id="subject_group_id" class="form-control" value="<?php echo $this->schedule->getSubjectGroup()->getSubject()->getAcronym()
                    . "_" . $this->schedule->getSubjectGroup()->getName() ?>" readonly/>
                </div>
                <div class="form-group">
                    <label for="space_id" data-translate="Aula"></label>
                    <input type="text" class="form-control" id="space_id" value="<?php echo $this->schedule->getSpace()->getName() ?>" readonly/>
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <input type="text" class="form-control" id="teacher_id" value="<?php echo $this->schedule->getTeacher()->getUser()->getName()
                        . " " . $this->schedule->getTeacher()->getUser()->getSurname() ?>" readonly/>
                </div>
                <div id="start-day-div" class="form-group">
                    <label for="day" data-translate="Día"></label>
                    <input type="date" class="form-control" id="day" name="day" value="<?php echo $this->schedule->getDay() ?>"
                           readonly>
                </div>
                <div id="start-hour-div" class="form-group">
                    <label for="start_hour" data-translate="Hora de inicio"></label>
                    <input type="time" class="form-control" id="start_hour" name="start_hour"
                           readonly value="<?php echo $this->schedule->getStartHour() ?>">
                </div>
                <div id="end-hour-div" class="form-group">
                    <label for="end_hour" data-translate="Hora de fin"></label>
                    <input type="time" class="form-control" id="end_hour" name="end_hour"
                           readonly value="<?php echo $this->schedule->getEndHour() ?>">
                </div>
        </main>
        <?php
    }
}

?>
