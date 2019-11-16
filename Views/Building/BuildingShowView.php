<?php
class BuildingShowView {
    private $building;

    function __construct($buildingData){
        $this->building = $buildingData;
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
                <h1 class="h2" data-translate="Edificio '%<?php echo $this->building->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/BuildingController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/BuildingController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->building->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location" data-translate="Introducir localización"
                           value="<?php echo $this->building->getLocation() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id" data-translate="Responsable"
                           value="<?php echo $this->building->getUser()->getName()." ".$this->building->getUser()->getSurname() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}
?>
