<?php
class FuncActionShowAllView {
private $funcActions;
private $actions;
private $functionalities;

function __construct($funcActionsData, $actionsData, $functionalitiesData){
    $this->funcActions = $funcActionsData;
    $this->actions = $actionsData;
    $this->functionalities = $functionalitiesData;
    $this->render();
}
function render(){
?>
<head>
	<link rel="stylesheet" href="../CSS/default.css" />
	<link rel="stylesheet" href="../CSS/table.css" />
</head>
<main role="main" class="margin-main ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
        <h1 class="h2" ><p data-translate="Listado de acciones-funcionalidades"></p></h1>
        <a class="btn btn-success" role="button" href="../Controllers/FuncActionController.php?action=add">
            <span data-feather="plus"></span><p data-translate="Añadir acción-funcionalidad"></p></a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th><label data-translate="Acción"></label></th>
                <th><label data-translate="Funcionalidad"></label></th>
				<th class="actions-row"><label data-translate="Acciones"></label></th>
            </tr>
            </thead>
            <?php if(!empty($this->funcActions)):?>
            <tbody>
                <?php foreach ($this->funcActions as $funcAction): ?>
                <tr>
                    <?php foreach ($this->actions as $action): ?>
                        <?php if($action->getIdAction() == $funcAction->getIdAction()):?>
                            <td><?php echo $action->getName() ;?></td>
                        <?php endif;?>
                    <?php endforeach;?>

                    <?php foreach ($this->functionalities as $func): ?>
                        <?php if($func->getIdFunctionality() == $funcAction->getIdFunctionality()):?>
                            <td><?php echo $func->getName() ;?></td>
                        <?php endif;?>
                    <?php endforeach;?>

                    <td class="row">
                        <a href="../Controllers/FuncActionController.php?action=show&IdFuncAction=<?php echo $funcAction->getIdFuncAction()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/FuncActionController.php?action=edit&IdFuncAction=<?php echo $funcAction->getIdFuncAction()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/FuncActionController.php?action=delete&IdFuncAction=<?php echo $funcAction->getIdFuncAction()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p data-translate="No se ha obtenido ninguna acción-funcionalidad"></p>
            <?php endif; ?>
    </div>
</main>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
<?php
    }
}
?>