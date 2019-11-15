<?php
class FunctionalityEditView {
    private $functionality;
    function __construct($functionalityData){
        $this->functionality = $functionalityData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
			<script src="../JS/Validations/FunctionalityValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Editar funcionalidad '%<?php echo $this->functionality->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/FunctionalityController.php" data-translate="Volver"></a>
            </div>
            <form name = "actionForm" action='../Controllers/FunctionalityController.php?action=edit&id=<?php echo $this->functionality->getId() ?>'
                  method='POST' onsubmit="return checkEditNameDescription()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->functionality->getName() ?>" required oninput="checkNameFunctionality(this);">
                </div>
                <div id="description-div" class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->functionality->getDescription() ?>" max-length="100" required oninput="checkDescriptionFunctionality(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
         <?php
    }
}
?>
