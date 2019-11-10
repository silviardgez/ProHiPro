<?php
class ActionEditView {
    private $action;
    function __construct($actionData){
        $this->action = $actionData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/ActionValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Editar acción '%<?php echo $this->action->getId()?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/ActionController.php" data-translate="Volver"></a>
            </div>
            <form  name = "actionForm" action='../Controllers/ActionController.php?action=edit&id=<?php echo $this->action->getId()?>'
                   method='POST' onsubmit="return areActionFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->action->getName() ?>" max-length="60" required oninput="checkNameAction(this);">
                </div>
                <div id="description-div" class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->action->getDescription() ?>" max-length="100" required oninput="checkDescriptionAction(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>