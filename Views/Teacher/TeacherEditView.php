<?php

class TeacherEditView
{
    private $teacher;
    private $spaces;
    private $users;

    function __construct($teacher, $users, $spaces)
    {
        $this->teacher = $teacher;
        $this->users = $users;
        $this->spaces = $spaces;
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
                <h1 class="h2" data-translate="Editar profesor '%<?php echo $this->teacher->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/TeacherController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="teacherForm" action='../Controllers/TeacherController.php?action=edit&id=<?php echo $this->teacher->getId()?>'
                  method='POST' onsubmit="areTeacherFieldsCorrect()">
                <div class="form-group">
                    <label for="user_id" data-translate="Usuario"></label>
                    <select class="form-control" id="user_id" name="user_id" ?>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"
                                <?php if ($user->getId() == $this->teacher->getUser()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $user->getName()." ". $user->getSurname(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="dedication-div" class="form-group">
                    <label for="dedication" data-translate="Dedicación"></label>
                    <input type="text" class="form-control" id="dedication" name="dedication"
                           data-translate="Introducir dedicación" required maxlength="4"
                           oninput="checkDedicationTeacher(this)" value="<?php echo $this->teacher->getDedication();?>">
                </div>
                <div class="form-group">
                    <label for="space_id" data-translate="Despacho"></label>
                    <select class="form-control" id="space_id" name="space_id" ?>
                        <option data-translate="Introducir despacho" value=""></option>
                        <?php foreach ($this->spaces as $space): ?>
                            <option value="<?php echo $space->getId() ?>"
                                <?php if ($space->getId() == $this->teacher->getSpace()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $space->getName(); ?>
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
