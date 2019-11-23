<?php

class DepartmentSearchView
{
    private $teachers;

    function __construct($teachers)
    {
        $this->teachers = $teachers;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/DepartmentValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Búsqueda de departamentos"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DepartmentController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="departmentForm" action='../Controllers/DepartmentController.php?action=search' method='POST'
                  onsubmit="areDepartmentSearchFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           maxlength="30" oninput="checkNameEmptyDepartment(this)">
                </div>
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code" data-translate="Introducir código"
                           maxlength="6" oninput="checkCodeEmptyDepartment(this)">
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
