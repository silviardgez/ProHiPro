<?php
class GroupEditView {
    private $group;
    private $subjects;

    function __construct($groupData, $subjectData){
        $this->group = $groupData;
        $this->subjects=$subjectData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/GroupValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar grupo '%<?php echo $this->group->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/GroupController.php"><p data-translate="Volver"></p></a>
            </div>
            <form id="groupForm" action='../Controllers/GroupController.php?action=edit&id=<?php echo $this->group->getId() ?>' method='POST'
                onsubmit="areGroupFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->group->getName() ?>" required maxlength="30" oninput="checkNameGroup(this)">
                </div>
                <div class="form-group">
                    <label for="subject_id" data-translate="Asignatura"></label>
                    <select class="form-control" id="subject_id" name="subject_id" required>
                        <?php foreach ($this->subjects as $subject): ?>
                            <option value="<?php echo $subject->getId()?>"
                                <?php if($subject->getId() == $this->group->getSubject()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $subject->getContent(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div id="capacity-div" class="form-group">
                    <label for="name" data-translate="Capacidad"></label>
                    <input type="number" min="0" max="999" class="form-control" id="capacity" name="capacity" data-translate="Introducir capacidad"
                           value="<?php echo $this->group->getCapacity() ?>" required maxlength="3" oninput="checkCapacityGroup(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>
