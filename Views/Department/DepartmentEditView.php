<?php

class DepartmentEditView
{
    private $department;
    private $teachers;

    function __construct($department, $teachers)
    {
        $this->department = $department;
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
                <h1 class="h2" data-translate="Editar departamento '%<?php echo $this->department->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DepartmentController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="departmentForm" action='../Controllers/DepartmentController.php?action=edit&id=<?php echo $this->department->getId() ?>'
                  method='POST' onsubmit="areDepartmentFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           required maxlength="30" oninput="checkNameDepartment(this)"
                           value="<?php echo $this->department->getName()?>">
                </div>
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code" data-translate="Introducir código"
                           required maxlength="6" oninput="checkCodeDepartment(this)"
                           value="<?php echo $this->department->getCode()?>">
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>"
                                <?php if ($teacher->getId() == $this->department->getTeacher()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $teacher->getUser()->getName()." ". $teacher->getUser()->getSurname(); ?>
                            </option>
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
