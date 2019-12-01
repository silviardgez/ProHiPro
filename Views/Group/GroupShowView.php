<?php
class GroupShowView {
    private $group;

    function __construct($groupData){
        $this->group = $groupData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Grupo '%<?php echo $this->group->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/GroupController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/GroupController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->group->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="subject_id" data-translate="Asignatura"></label>
                    <input type="text" class="form-control" id="subject_id" name="subject_id" data-translate="Introducir asignatura"
                           value="<?php echo $this->group->getSubject()->getContent() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Capacidad"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id" data-translate="Responsable"
                           value="<?php echo $this->group->getCapacity() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}
?>
