<?php
include_once '../Functions/HavePermission.php';

class BuildingShowAllView
{
    private $buildings;
    private $itemsPerPage;
    private $currentPage;
    private $totalBuildings;
    private $totalPages;
    private $stringToSearch;
    private $searching;

    function __construct($buildingsData, $itemsPerPage = NULL, $currentPage = NULL, $totalBuildings = NULL, $toSearch = NULL, $searching=False)
    {
        $this->buildings = $buildingsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalBuildings = $totalBuildings;
        $this->totalPages = ceil($totalBuildings / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->searching=$searching;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/table.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de edificios"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/BuildingController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/BuildingController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Building", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../Controllers/BuildingController.php?action=add">
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
                        <th><label data-translate="Localización"></label></th>
                        <th><label data-translate="Responsable"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->buildings)): ?>
                    <tbody>
                    <?php foreach ($this->buildings as $building): ?>
                        <tr>
                            <td><?php echo $building->getName() ;?></td>
                            <td><?php echo $building->getLocation() ;?></td>
                            <td><?php echo $building->getUser()->getName() . " " . $building->getUser()->getSurname() ;?></td>
                            <td class="row">
                                <?php if (HavePermission("Building", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/BuildingController.php?action=show&id=<?php echo $building->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Building", "EDIT")) { ?>
                                    <a href="../Controllers/BuildingController.php?action=edit&id=<?php echo $building->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Building", "DELETE")) { ?>
                                    <a href="../Controllers/BuildingController.php?action=delete&id=<?php echo $building->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún edificio">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalBuildings,
                    "Building") ?>

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
