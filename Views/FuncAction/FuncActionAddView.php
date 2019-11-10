<?php
class FuncActionAddView {
    private $actions;
    private $functionalities;
function __construct($actionsData, $functionalitiesData){
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2" ><p data-translate="Insertar acción-funcionalidad"></p></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/FuncActionController.php" data-translate="Volver"></a>
        </div>
        <form action='../Controllers/FuncActionController.php?action=add' method='POST'>
            <div class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <select class="form-control" id="idAction" name="idAction">
                    <?php foreach ($this->actions as $action): ?>
                        <option value="<?php echo $action->getIdAction()?>"><?php echo $action->getName() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="description" data-translate="Descripción"></label>
                <select class="form-control" id="idFunctionality" name="idFunctionality"?>
                    <?php foreach ($this->functionalities as $func): ?>
                        <option value="<?php echo $func->getIdFunctionality() ?>"><?php echo $func->getName() ?></option>
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


