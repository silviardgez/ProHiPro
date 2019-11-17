<?php
class BuildingEditView {
    private $building;
    private $users;

    function __construct($buildingData, $users){
        $this->building = $buildingData;
        $this->users=$users;
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
                <h1 class="h2" data-translate="Editar edificio '%<?php echo $this->building->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/BuildingController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/BuildingController.php?action=edit&id=<?php echo $this->building->getId() ?>' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->building->getName() ?>">
                </div>
                <div class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location" data-translate="Introducir localización"
                           value="<?php echo $this->building->getLocation() ?>">
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id"?>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId()?>"
                                <?php if($user->getId() == $this->building->getUser()->getId()){echo 'selected="selected"';}?>>
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
