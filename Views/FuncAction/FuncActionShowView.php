<?php
class FuncActionShowView {
private $funcAction;
private $actions;
private $functionalities;
    function __construct($funcActionsData, $actionsData, $functionalitiesData){
        $this->funcAction = $funcActionsData;
        $this->actions = $actionsData;
        $this->functionalities = $functionalitiesData;
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
                <h1 class="h2" ><p data-translate="Acción Funcionalidad"></p></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/FuncActionController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->funcAction)): ?>
            <form>
                <div class="form-group">
                    <label for="name" data-translate="Acción"></label>
                    <?php foreach ($this->actions as $action): ?>
                        <?php if ($action->getIdAction() == $this->funcAction->getIdAction()):?>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?php echo $action->getName(); ?>" readonly>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Funcionalidad"></label>
                    <?php foreach ($this->functionalities as $func): ?>
                        <?php if ($func->getIdFunctionality() == $this->funcAction->getIdFunctionality()):?>
                        <input type="text" class="form-control" id="description" name="description"
                               value="<?php echo $func->getName() ?>" readonly>
                        <?php endif;?>
                    <?php endforeach; ?>
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