<?php
class DegreeEditView {
    private $universities;
    private $degree;
    private $users;
    private $buildings;

    function __construct($degreeData, $universities,$users,$buildingData){
        $this->universities = $universities;
        $this->degree = $degreeData;
        $this->users=$users;
        $this->buildings=$buildingData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/DegreeValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-degree pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar titulación '%<?php echo $this->degree->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DegreeController.php"><p data-translate="Volver"></p></a>
            </div>
            <form id="degreeForm" action='../Controllers/DegreeController.php?action=edit&id=<?php echo $this->degree->getId() ?>'
                  method='POST' onsubmit="areDegreeFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->degree->getName() ?>" required maxlength="30" oninput="checkNameDegree(this)">
                </div>
                <div class="form-group">
                    <label for="university_id" data-translate="Universidad"></label>
                    <select class="form-control" id="university_id" name="university_id" required>
                        <?php foreach ($this->universities as $university): ?>
                            <option value="<?php echo $university->getId()?>"
                                <?php if($university->getId() == $this->degree->getUniversity()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $university->getName(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="building_id" data-translate="Edificio"></label>
                    <select class="form-control" id="building_id" name="building_id" required>
                        <?php foreach ($this->buildings as $building): ?>
                            <option value="<?php echo $building->getId()?>"
                                <?php if($building->getId() == $this->degree->getBuilding()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $building->getName(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId()?>"
                                <?php if($user->getId() == $this->degree->getUser()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $user->getName()." ".$user->getSurname(); ?>
                            </option>
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
