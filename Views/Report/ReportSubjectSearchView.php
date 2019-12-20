<?php

class ReportSubjectSearchView
{
    private $universities;
    private $departments;

    function __construct($universities, $departments)
    {
        $this->universities = $universities;
        $this->departments = $departments;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/UniversityValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Búsqueda de centros"></h1>
            </div>
            <form id="universitySearchForm" action='../Controllers/ReportController.php?action=search' method='POST'
            ">
            <div class="form-group">
                <label for="academic_course_id" data-translate="Universidad"></label>
                <select class="form-control" id="degree" name="degree" ?>
                    <option data-translate="Introducir titulación" value=""></option>
                    <?php foreach ($this->universities as $university): ?>
                        <option value="<?php echo $university->getId() ?>"><?php echo $university->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="department_id" data-translate="Departamento"></label>
                <select class="form-control" id="department" name="department" ?>
                    <?php foreach ($this->departments as $department): ?>
                        <option value="<?php echo $department->getId() ?>">
                            <?php echo $department->getName();?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="type-div" class="form-group">
                <label for="type" data-translate="Tipo"></label>
                <input type="text" class="form-control" id="type" name="type" data-translate="Introducir tipo"
                       required maxlength="2" oninput="checkTypeSubject(this)">
            </div>
            <div id="course-div" class="form-group">
                <label for="course" data-translate="Curso"></label>
                <input type="text" class="form-control" id="course" name="course" data-translate="Introducir curso"
                       required maxlength="10" oninput="checkCourseSubject(this)">
            </div>
            <div id="quarter-div" class="form-group">
                <label for="quarter" data-translate="Cuatrimestre"></label>
                <input type="text" class="form-control" id="quarter" name="quarter" data-translate="Introducir cuatrimestre"
                       required maxlength="3" oninput="checkQuarterSubject(this)">
            </div>
            <input type="hidden" id="entity" name="entity" value="subject"/>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
<?php
