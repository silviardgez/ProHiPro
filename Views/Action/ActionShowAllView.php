<?php
class ActionShowAllView {
private $actions;

function __construct($actionsData){
    $this->actions = $actionsData;
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
        <h1 class="h2" data-translate="Listado de acciones"></h1>
        <a class="btn btn-success" role="button" href="../Controllers/ActionController.php?action=add">
            <span data-feather="plus"></span><p data-translate="Añadir acción"></p></a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th data-translate="Id acción"></th>
                <th data-translate="Nombre"></th>
                <th data-translate="Descripción"></th>
				<th class="actions-row" data-translate="Acciones"></th>
            </tr>
            </thead>
            <?php if(!empty($this->actions)):?>
            <tbody>
                <?php foreach ($this->actions as $action): ?>
                <tr>
                    <td><?php echo $action->getIdAction() ?></td>
                    <td><?php echo $action->getName() ?></td>
                    <td><?php echo $action->getDescription() ?></td>
                    <td class="row">
                        <a href="../Controllers/ActionController.php?action=show&IdAction=<?php echo $action->getIdAction()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/ActionController.php?action=edit&IdAction=<?php echo $action->getIdAction()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/ActionController.php?action=delete&IdAction=<?php echo $action->getIdAction()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p data-translate="No se ha obtenido ninguna acción">. </p>
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

<script>
    translatePage(getCookie("language-selected"));
</script>
