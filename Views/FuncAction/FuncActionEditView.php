<?php
class FuncActionEditView {
    private $funcAction;
    private $actions;
    private $functionalities;

    function __construct($funcActionData, $actionsData, $functionalitiesData){
        $this->funcAction = $funcActionData;
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
                <h1 class="h2" data-translate="Editar acción-funcionalidad '%<?php echo $this->funcAction->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/FuncActionController.php" data-translate="Volver"></a>
            </div>
            <form action='../Controllers/FuncActionController.php?action=edit&id=<?php echo $this->funcAction->getId() ?>' method='POST'>
                <div class="form-group">
                    <label for="action_id" data-translate="Acción"></label>
                    <select class="form-control" id="action_id" name="action_id">
                        <?php foreach ($this->actions as $action): ?>
                            <option value="<?php echo $action->getId()?>"
                                <?php if($action->getId() == $this->funcAction->getAction()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $action->getName(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="functionality_id" data-translate="Funcionalidad"></label>
                    <select class="form-control" id="functionality_id" name="functionality_id">
                        <?php foreach($this->functionalities as $func): ?>
                            <option value="<?php echo $func->getId()?>"
                                <?php if($func->getId() == $this->funcAction->getFunctionality()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $func->getName(); ?>
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

