<?php

class DepartmentShowView
{
    private $department;

    function __construct($department)
    {
        $this->department = $department;
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
                <h1 class="h2" data-translate="Departamento '%<?php echo $this->department->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DepartmentController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="departmentForm" method='POST'>
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->department->getName()?>" readonly>
                </div>
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code"
                           value="<?php echo $this->department->getCode()?>" readonly>
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <input type="text" class="form-control" id="teacher_id" name="teacher_id"
                           value="<?php echo $this->department->getTeacher()->getUser()->getName() . " " .
                               $this->department->getTeacher()->getUser()->getSurname()?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}

?>
