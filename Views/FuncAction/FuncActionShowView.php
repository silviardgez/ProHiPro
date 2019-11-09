<?php
class FuncActionShowView {
    private $funcAction;
    function __construct($funcActionsData){
        $this->funcAction = $funcActionsData;
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
                <h1 class="h2" data-translate="Acción-funcionalidad '%<?php echo $this->funcAction->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/FuncActionController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->funcAction)): ?>
                <form>
                    <div class="form-group">
                        <label for="action_id" data-translate="Acción"></label>
                        <input type="text" class="form-control" id="action_id" name="action_id"
                               value="<?php echo $this->funcAction->getAction()->getName(); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description" data-translate="Funcionalidad"></label>
                        <input type="text" class="form-control" id="description" name="description"
                               value="<?php echo $this->funcAction->getFunctionality()->getName() ?>" readonly>
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