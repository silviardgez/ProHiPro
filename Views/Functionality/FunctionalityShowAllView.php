<?php
class FunctionalityShowAllView {
private $functionalities;

function __construct($functionalitiesData){
    $this->functionalities = $functionalitiesData;
    $this->render();
}
function render(){
?>
<head><link rel="stylesheet" href="../CSS/default.css" /></head>
<main role="main" class="margin-main ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
        <h1 class="h2">Listado de funcionalidades</h1>
        <a class="btn btn-success" role="button" href="../Controllers/FunctionalityController.php?action=add">
            <span data-feather="plus"></span> Añadir funcionalidad</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>IdFunctionality</th>
                <th>Nombre</th>
                <th>Descripción</th>
				<th class="actions-row">Acciones</th>
            </tr>
            </thead>
            <?php if(!empty($this->functionalities)):?>
            <tbody>
                <?php foreach ($this->functionalities as $functionality): ?>
                <tr>
                    <td><?php echo $functionality->getIdFunctionality() ?></td>
                    <td><?php echo $functionality->getName() ?></td>
                    <td><?php echo $functionality->getDescription() ?></td>                 
                    <td class="row">
                        <a href="../Controllers/FunctionalityController.php?action=show&IdFunctionality=<?php echo $functionality->getIdFunctionality()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/FunctionalityController.php?action=edit&IdFunctionality=<?php echo $functionality->getIdFunctionality()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/FunctionalityController.php?action=delete&IdFunctionality=<?php echo $functionality->getIdFunctionality()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p> No se ha obtenido ninguna funcionalidad. </p>
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