<?php
class SpaceAddView {
    private $buildings;

    function __construct($buildingData){
        $this->buildings=$buildingData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/SpaceValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Insertar espacio"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/SpaceController.php"><p data-translate="Volver"></p></a>
            </div>
            <form id="spaceForm" action='../Controllers/SpaceController.php?action=add' method='POST'
                  onsubmit="areSpaceFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           required maxlength="30" oninput="checkNameSpace(this)">
                </div>
                <div class="form-group">
                    <label for="building_id" data-translate="Edificio"></label>
                    <select class="form-control" id="building_id" name="building_id" required>
                        <?php foreach ($this->buildings as $building): ?>
                            <option value="<?php echo $building->getId() ?>"><?php echo $building->getName() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div id="capacity-div" class="form-group">
                    <label for="capacity" data-translate="Capacidad"></label>
                    <input type="number" min="0" max ="999" class="form-control" id="capacity" name="capacity"
                           data-translate="Capacidad" required maxlength="3" oninput="checkCapacitySpace(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>
