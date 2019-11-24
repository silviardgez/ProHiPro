<?php

class SubjectShowView
{
    private $subject;

    function __construct($subject)
    {
        $this->subject = $subject;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/SubjectValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Asignatura '%<?php echo $this->subject->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/SubjectController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="subjectForm" method='POST'>
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code"
                            value="<?php echo $this->subject->getCode() ?>" readonly>
                </div>
                <div id="content-div" class="form-group">
                    <label for="content" data-translate="Contenido"></label>
                    <input type="text" class="form-control" id="content" name="content"
                           value="<?php echo $this->subject->getContent() ?>" readonly>
                </div>
                <div id="type-div" class="form-group">
                    <label for="type" data-translate="Tipo"></label>
                    <input type="text" class="form-control" id="type" name="type"
                           value="<?php echo $this->subject->getType() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="department_id" data-translate="Departamento"></label>
                    <input type="text" class="form-control" id="department_id" name="department_id"
                           value="<?php echo $this->subject->getDepartment()->getName() ?>" readonly>
                </div>
                <div id="area-div" class="form-group">
                    <label for="area" data-translate="Área"></label>
                    <input type="text" class="form-control" id="area" name="area"
                           value="<?php echo $this->subject->getArea() ?>" readonly>
                </div>
                <div id="course-div" class="form-group">
                    <label for="course" data-translate="Curso"></label>
                    <input type="text" class="form-control" id="course" name="course"
                           value="<?php echo $this->subject->getCourse() ?>" readonly>
                </div>
                <div id="quarter-div" class="form-group">
                    <label for="quarter" data-translate="Cuatrimestre"></label>
                    <input type="text" class="form-control" id="quarter" name="quarter"
                           value="<?php echo $this->subject->getQuarter() ?>" readonly>
                </div>
                <div id="credits-div" class="form-group">
                    <label for="credits" data-translate="Créditos"></label>
                    <input type="text" class="form-control" id="credits" name="credits"
                           value="<?php echo $this->subject->getCredits() ?>" readonly>
                </div>
                <div id="new-registrarion-div" class="form-group">
                    <label for="new_registration" data-translate="Número de nueva matrícula"></label>
                    <input type="number" class="form-control" id="new_registration" name="new_registration"
                           value="<?php echo $this->subject->getNewRegistration() ?>" readonly>
                </div>
                <div id="repeaters-div" class="form-group">
                    <label for="repeaters" data-translate="Número de repetidores"></label>
                    <input type="number" class="form-control" id="repeaters" name="repeaters"
                           value="<?php echo $this->subject->getRepeaters() ?>" readonly>
                </div>
                <div id="effective-students-div" class="form-group">
                    <label for="effective_students" data-translate="Número de alumnos efectivos"></label>
                    <input type="number" class="form-control" id="effective_students" name="effective_students"
                           value="<?php echo $this->subject->getEffectiveStudents() ?>" readonly>
                </div>
                <div id="enrolled-hours-div" class="form-group">
                    <label for="enrolled_hours" data-translate="Número de horas matriculadas"></label>
                    <input type="text" class="form-control" id="enrolled_hours" name="enrolled_hours"
                           value="<?php echo $this->subject->getEnrolledHours() ?>" readonly>
                </div>
                <div id="taught-hours-div" class="form-group">
                    <label for="taught_hours" data-translate="Número de horas impartidas"></label>
                    <input type="text" class="form-control" id="taught_hours" name="taught_hours"
                           value="<?php echo $this->subject->getTaughtHours() ?>" readonly>
                </div>
                <div id="hours-div" class="form-group">
                    <label for="hours" data-translate="Número de horas"></label>
                    <input type="text" class="form-control" id="hours" name="hours"
                           value="<?php echo $this->subject->getHours() ?>" readonly>
                </div>
                <div id="students-div" class="form-group">
                    <label for="students" data-translate="Estudiantes"></label>
                    <input type="number" class="form-control" id="students" name="students"
                           value="<?php echo $this->subject->getStudents() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="degree_id" data-translate="Titulación"></label>
                    <input type="text" class="form-control" id="degree_id" name="degree_id"
                           value="<?php echo $this->subject->getDegree()->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <input type="text" class="form-control" id="teacher_id" name="teacher_id" readonly
                           value="<?php echo $this->subject->getTeacher()->getUser()->getName()." ".
                               $this->subject->getTeacher()->getUser()->getSurname() ?>">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
