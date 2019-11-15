<?php
class FuncActionShowAllView {
private $funcActions;
private $itemsPerPage;
private $currentPage;
private $totalFuncActions;
private $totalPages;
private $stringToSearch;

function __construct($funcActionsData, $itemsPerPage=NULL, $currentPage=NULL, $totalFuncActions=NULL, $stringToSearch=NULL){
    $this->funcActions = $funcActionsData;
    $this->itemsPerPage = $itemsPerPage;
    $this->currentPage = $currentPage;
    $this->totalFuncActions = $totalFuncActions;
    $this->totalPages = ceil($totalFuncActions/$itemsPerPage);
    $this->stringToSearch = $stringToSearch;
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
        <h1 class="h2" data-translate="Listado de acciones-funcionalidades"></h1>
        <?php if (!empty($this->stringToSearch)): ?>
            <a class="btn btn-primary" role="button" href="../Controllers/FuncActionController.php">
                <p data-translate="Volver"></p>
            </a>
        <?php else:?>
            <a class="btn btn-success" role="button" href="../Controllers/FuncActionController.php?action=add">
                <span data-feather="plus"></span><p data-translate="Añadir acción-funcionalidad"></p>
            </a>
        <?php endif;?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th><label data-translate="Acción"></label></th>
                <th><label data-translate="Funcionalidad"></label></th>
				<th><label data-translate="Acciones"></label></th>
            </tr>
            </thead>
            <?php if(!empty($this->funcActions)):?>
            <tbody>
                <?php foreach ($this->funcActions as $funcAction): ?>
                <tr>
                    <td><?php echo $funcAction->getAction()->getName() ;?></td>
                    <td><?php echo $funcAction->getFunctionality()->getName() ;?></td>
                    <td class="row">
                        <a href="../Controllers/FuncActionController.php?action=show&id=<?php echo $funcAction->getId()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/FuncActionController.php?action=edit&id=<?php echo $funcAction->getId()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/FuncActionController.php?action=delete&id=<?php echo $funcAction->getId()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p data-translate="No se ha obtenido ninguna acción-funcionalidad">.</p>
            <?php endif; ?>

        <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalFuncActions, "FuncAction"); ?>
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