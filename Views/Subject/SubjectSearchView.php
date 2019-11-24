<?php

class SubjectSearchView
{
    private $degrees;
    private $departments;
    private $teachers;

    function __construct($degrees, $departments, $teachers)
    {
        $this->degrees = $degrees;
        $this->departments = $departments;
        $this->teachers = $teachers;
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
                <h1 class="h2" data-translate="Búsqueda de asignaturas"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/SubjectController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="subjectSearchForm" action='../Controllers/SubjectController.php?action=search' method='POST'
                  onsubmit="areSubjectSearchFieldsCorrect()">
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code" data-translate="Introducir código"
                           maxlength="10" oninput="checkCodeEmptySubject(this)">
                </div>
                <div id="content-div" class="form-group">
                    <label for="content" data-translate="Contenido"></label>
                    <input type="text" class="form-control" id="content" name="content" data-translate="Introducir contenido"
                           maxlength="100" oninput="checkContentEmptySubject(this)">
                </div>
                <div id="type-div" class="form-group">
                    <label for="type" data-translate="Tipo"></label>
                    <input type="text" class="form-control" id="type" name="type" data-translate="Introducir tipo"
                           maxlength="2" oninput="checkTypeEmptySubject(this)">
                </div>
                <div class="form-group">
                    <label for="department_id" data-translate="Departamento"></label>
                    <select class="form-control" id="department_id" name="department_id" ?>
                        <option data-translate="Introducir departamento" value=""></option>
                        <?php foreach ($this->departments as $department): ?>
                            <option value="<?php echo $department->getId() ?>">
                                <?php echo $department->getName();?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="area-div" class="form-group">
                    <label for="area" data-translate="Área"></label>
                    <input type="text" class="form-control" id="area" name="area" data-translate="Introducir área"
                           maxlength="5" oninput="checkAreaEmptySubject(this)">
                </div>
                <div id="course-div" class="form-group">
                    <label for="course" data-translate="Curso"></label>
                    <input type="text" class="form-control" id="course" name="course" data-translate="Introducir curso"
                           maxlength="10" oninput="checkCourseEmptySubject(this)">
                </div>
                <div id="quarter-div" class="form-group">
                    <label for="quarter" data-translate="Cuatrimestre"></label>
                    <input type="text" class="form-control" id="quarter" name="quarter" data-translate="Introducir cuatrimestre"
                           maxlength="3" oninput="checkQuarterEmptySubject(this)">
                </div>
                <div id="credits-div" class="form-group">
                    <label for="credits" data-translate="Créditos"></label>
                    <input type="text" class="form-control" id="credits" name="credits" data-translate="Introducir créditos"
                           maxlength="5" oninput="checkCreditsEmptySubject(this)">
                </div>
                <div id="new-registrarion-div" class="form-group">
                    <label for="new_registration" data-translate="Número de nueva matrícula"></label>
                    <input type="number" class="form-control" id="new_registration" name="new_registration"
                           data-translate="Introducir número de nueva matrícula"
                           maxlength="3" oninput="checkNewRegistrationEmptySubject(this)">
                </div>
                <div id="repeaters-div" class="form-group">
                    <label for="repeaters" data-translate="Número de repetidores"></label>
                    <input type="number" class="form-control" id="repeaters" name="repeaters"
                           data-translate="Introducir número de repetidores"
                           maxlength="3" oninput="checkRepeatersEmptySubject(this)">
                </div>
                <div id="effective-students-div" class="form-group">
                    <label for="effective_students" data-translate="Número de alumnos efectivos"></label>
                    <input type="number" class="form-control" id="effective_students" name="effective_students"
                           data-translate="Introducir número de alumnos efectivos"
                           maxlength="3" oninput="checkEffectiveStudentsEmptySubject(this)">
                </div>
                <div id="enrolled-hours-div" class="form-group">
                    <label for="enrolled_hours" data-translate="Número de horas matriculadas"></label>
                    <input type="text" class="form-control" id="enrolled_hours" name="enrolled_hours"
                           data-translate="Introducir número de horas matriculadas"
                           maxlength="8" oninput="checkEnrolledHoursEmptySubject(this)">
                </div>
                <div id="taught-hours-div" class="form-group">
                    <label for="taught_hours" data-translate="Número de horas impartidas"></label>
                    <input type="text" class="form-control" id="taught_hours" name="taught_hours"
                           data-translate="Introducir número de horas impartidas"
                           maxlength="5" oninput="checkTaughtHoursEmptySubject(this)">
                </div>
                <div id="hours-div" class="form-group">
                    <label for="hours" data-translate="Número de horas"></label>
                    <input type="text" class="form-control" id="hours" name="hours"
                           data-translate="Introducir número de horas"
                           maxlength="5" oninput="checkHoursEmptySubject(this)">
                </div>
                <div id="students-div" class="form-group">
                    <label for="students" data-translate="Estudiantes"></label>
                    <input type="number" class="form-control" id="students" name="students"
                           data-translate="Introducir estudiantes"
                           maxlength="3" oninput="checkStudentsEmptySubject(this)">
                </div>
                <div class="form-group">
                    <label for="degree_id" data-translate="Titulación"></label>
                    <select class="form-control" id="degree_id" name="degree_id" ?>
                        <option data-translate="Introducir titulación" value=""></option>
                        <?php foreach ($this->degrees as $degree): ?>
                            <option value="<?php echo $degree->getId() ?>">
                                <?php echo $degree->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
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
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
