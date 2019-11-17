<?php
class DegreeShowView {
    private $degree;

    function __construct($degreeData){
        $this->degree = $degreeData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-degree pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Centro '%<?php echo $this->degree->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DegreeController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/DegreeController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->degree->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="university_id" data-translate="Universidad"></label>
                    <input type="text" class="form-control" id="university_id" name="university_id" data-translate="Introducir universidad"
                           value="<?php echo $this->degree->getUniversity()->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="building_id" data-translate="Edificio"></label>
                    <input type="text" class="form-control" id="building_id" name="building_id" data-translate="Introducir edificio"
                           value="<?php echo $this->degree->getBuilding()->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id" data-translate="Responsable"
                           value="<?php echo $this->degree->getUser()->getName()." ".$this->degree->getUser()->getSurname() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}
?>
