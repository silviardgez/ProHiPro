<?php
class BuildingSearchView {
private $users;

    function __construct($userData){
        $this->users = $userData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/BuildingValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Búsqueda de edificios"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/BuildingController.php"><p data-translate="Volver"></p></a>
            </div>
            <form id="buildingSearchForm" action='../Controllers/BuildingController.php?action=search' method='POST'
                  onsubmit="return areBuildingSearchFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                    maxlength="30" oninput="checkNameEmptyBuilding(this)">
                </div>
                <div id="location-div" class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location" data-translate="Introducir localización"
                    maxlength="30" oninput="checkLocationEmptyBuilding(this)">
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id">
                        <option data-translate="Introducir responsable" value=""></option>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"><?php echo $user->getName()." ".$user->getSurname() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>
