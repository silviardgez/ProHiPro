<?php
include_once '../Functions/HavePermission.php';

class CenterShowAllView
{
    private $centers;
    private $itemsPerPage;
    private $currentPage;
    private $totalCenters;
    private $totalPages;
    private $stringToSearch;
    private $searching;

    function __construct($centersData, $itemsPerPage = NULL, $currentPage = NULL, $totalCenters = NULL, $toSearch = NULL, $searching=False)
    {
        $this->centers = $centersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalCenters = $totalCenters;
        $this->totalPages = ceil($totalCenters / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->searching=$searching;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/table.css"/>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de centros"></h1>

                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/CenterController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Center", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/CenterController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir centro"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Universidad"></label></th>
                        <th><label data-translate="Edificio"></label></th>
                        <th><label data-translate="Responsable"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->centers)): ?>
                    <tbody>
                    <?php foreach ($this->centers as $center): ?>
                        <tr>
                            <td><?php echo $center->getName() ;?></td>
                            <td><?php echo $center->getUniversity()->getName() ;?></td>
                            <td><?php echo $center->getBuilding()->getName() ;?></td>
                            <td><?php echo $center->getUser()->getName() . " " . $center->getUser()->getSurname();?></td>
                            <td class="row">
                                <?php if (HavePermission("Center", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/CenterController.php?action=show&id=<?php echo $center->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Center", "EDIT")) { ?>
                                    <a href="../Controllers/CenterController.php?action=edit&id=<?php echo $center->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Center", "DELETE")) { ?>
                                    <a href="../Controllers/CenterController.php?action=delete&id=<?php echo $center->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún centro">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalCenters,
                    "Center") ?>

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
