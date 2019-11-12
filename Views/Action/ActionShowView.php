<?php
class ActionShowView {
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
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Acción"> <?php echo $_REQUEST['IdAction'] ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/ActionController.php" data-translate="Volver"></a>
            </div>
            <?php if(!is_null($this->action)): ?>
            <form>
                <div class="form-group">
                    <label for="IdAction" data-translate="Id acción"></label>
                    <input type="text" class="form-control" id="IdAction" name="IdAction"
                           value="<?php echo $this->action->getIdAction() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->action->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->action->getDescription() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="La acción no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>
