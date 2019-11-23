<?php

class TeacherShowView
{
    private $teacher;

    function __construct($teacher)
    {
        $this->teacher = $teacher;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/TeacherValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Profesor '%<?php echo $this->teacher->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/TeacherController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="teacherForm" method='POST'>
                <div class="form-group">
                    <label for="user_id" data-translate="Usuario"></label>
                    <input type="text" class="form-control" id="dedication" name="dedication" readonly
                           value="<?php echo $this->teacher->getUser()->getName() . " " . $this->teacher->getUser()->getSurname()?>">
                </div>
                <div id="dedication-div" class="form-group">
                    <label for="dedication" data-translate="Dedicación"></label>
                    <input type="text" class="form-control" id="dedication" name="dedication"
                           value="<?php echo $this->teacher->getDedication();?>" readonly>
                </div>
                <div class="form-group">
                    <label for="space_id" data-translate="Despacho"></label>
                    <?php if(!empty($this->teacher->getSpace())): ?>
                    <input type="text" class="form-control" id="space_id" name="space_id" readonly
                           value="<?php echo $this->teacher->getSpace()->getName()?>">
                    <?php else: ?>
                        <input type="text" class="form-control" id="space_id" name="space_id" readonly
                               data-translate="No asignado">
                    <?php endif; ?>
                </div>
            </form>
        </main>
        <?php
    }
}

?>
