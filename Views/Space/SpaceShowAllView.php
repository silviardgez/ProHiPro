<?php
class SpaceShowAllView {
    private $spaces;
    private $itemsPerPage;
    private $currentPage;
    private $totalSpaces;
    private $totalPages;
    private $stringToSearch;

    function __construct($spacesData, $itemsPerPage=NULL, $currentPage=NULL, $totalSpaces=NULL, $toSearch=NULL){
        $this->spaces = $spacesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalSpaces = $totalSpaces;
        $this->totalPages = ceil($totalSpaces/$itemsPerPage);
        $this->stringToSearch = $toSearch;
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
                <h1 class="h2" data-translate="Listado de espacios"></h1>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/SpaceController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:?>
                    <a class="btn btn-success" role="button" href="../Controllers/SpaceController.php?action=add">
                        <span data-feather="plus"></span><p data-translate="Añadir espacio"></p>
                    </a>
                <?php endif;?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Edificio"></label></th>
                        <th><label data-translate="Capacidad"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if(!empty($this->spaces)):?>
                    <tbody>
                    <?php foreach ($this->spaces as $space): ?>
                        <tr>
                            <td><?php echo $space->getName() ;?></td>
                            <td><?php echo $space->getBuilding()->getName() ;?></td>
                            <td><?php echo $space->getCapacity() ;?></td>
                            <td class="row">
                                <a href="../Controllers/SpaceController.php?action=show&id=<?php echo $space->getId()?>">
                                    <span data-feather="eye"></span></a>
                                <a href="../Controllers/SpaceController.php?action=edit&id=<?php echo $space->getId()?>">
                                    <span data-feather="edit"></span></a>
                                <a href="../Controllers/SpaceController.php?action=delete&id=<?php echo $space->getId()?>">
                                    <span data-feather="trash-2"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún espacio">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalSpaces,
                    "Space")?>

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
