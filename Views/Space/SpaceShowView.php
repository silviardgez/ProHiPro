<?php
class SpaceShowView {
    private $space;

    function __construct($spaceData){
        $this->space = $spaceData;
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
                <h1 class="h2" data-translate="Espacio '%<?php echo $this->space->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/SpaceController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/SpaceController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->space->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="building_id" data-translate="Edificio"></label>
                    <input type="text" class="form-control" id="building_id" name="building_id" data-translate="Introducir edificio"
                           value="<?php echo $this->space->getBuilding()->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Capacidad"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id" data-translate="Responsable"
                           value="<?php echo $this->space->getCapacity() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="office" data-translate="Despacho"></label>
                    <input type="checkbox" class="office-checkbox" id="office" name="office"
                        <?php if($this->space->isOffice()) echo "checked"?> onclick="return false;">
                </div>
            </form>
        </main>
        <?php
    }
}
?>
