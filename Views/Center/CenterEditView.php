<?php
class CenterEditView {
    private $universities;
    private $center;
    private $users;
    private $buildings;

    function __construct($centerData, $universities,$users,$buildingData){
        $this->universities = $universities;
        $this->center = $centerData;
        $this->users=$users;
        $this->buildings=$buildingData;
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
                <h1 class="h2" data-translate="Editar centro '%<?php echo $this->center->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/CenterController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/CenterController.php?action=edit&id=<?php echo $this->center->getId() ?>' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->center->getName() ?>" required>
                </div>
                <div class="form-group">
                    <label for="university_id" data-translate="Universidad"></label>
                    <select class="form-control" id="university_id" name="university_id" required>
                        <?php foreach ($this->universities as $university): ?>
                            <option value="<?php echo $university->getId()?>"
                                <?php if($university->getId() == $this->center->getUniversity()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $university->getName(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <select class="form-control" id="building_id" name="building_id" required>
                        <?php foreach ($this->buildings as $building): ?>
                            <option value="<?php echo $building->getId()?>"
                                <?php if($building->getId() == $this->center->getBuilding()->getId()){echo 'selected="selected"';}?>>
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
                                <?php if($user->getId() == $this->center->getUser()->getId()){echo 'selected="selected"';}?>>
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
