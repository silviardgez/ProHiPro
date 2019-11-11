<?php
class FuncActionEditView {
    private $funcAction;
    private $actions;
    private $functionalities;
    function __construct($funcActionData,$actionsData, $functionalitiesData){
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
                <h1 class="h2"><label data-translate="Acción"></label> <?php echo $this->funcAction->getIdFuncAction() ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/FuncActionController.php" data-translate="Volver"></a>
            </div>
            <form action='../Controllers/FuncActionController.php?action=edit&IdFuncAction=<?php echo $this->funcAction->getIdFuncAction() ?>' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Acción"></label>
                    <select class="form-control" id="idAction" name="idAction">
                        <?php foreach ($this->actions as $action): ?>
                            <option value="<?php echo $action->getIdAction()?>" <?php if($action->getIdAction()==$this->funcAction->getIdAction()): echo 'selected="selected"'; endif;?>><?php echo $action->getName() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Funcionalidad"></label>
                    <select class="form-control" id="idFunctionality" name="idFunctionality">
                        <?php foreach($this->functionalities as $func): ?>
                            <option value="<?php echo $func->getIdFunctionality()?>" <?php if($func->getIdFunctionality() == $this->funcAction->getIdFunctionality()): echo 'selected="selected"'; endif;?>><?php echo $func->getName()?></option>
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

<script>
    translatePage(getCookie("language-selected"));
</script>
