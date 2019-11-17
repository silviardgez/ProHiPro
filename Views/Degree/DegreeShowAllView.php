<?php
include_once '../Functions/HavePermission.php';

class DegreeShowAllView
{
    private $degrees;
    private $itemsPerPage;
    private $currentPage;
    private $totalDegrees;
    private $totalPages;
    private $stringToSearch;

    function __construct($degreesData, $itemsPerPage = NULL, $currentPage = NULL, $totalDegrees = NULL, $toSearch = NULL)
    {
        $this->degrees = $degreesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalDegrees = $totalDegrees;
        $this->totalPages = ceil($totalDegrees / $itemsPerPage);
        $this->stringToSearch = $toSearch;
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-degree pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de titulaciones"></h1>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/DegreeController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Degree", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../Controllers/DegreeController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir titulación"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Centro"></label></th>
                        <th><label data-translate="Plazas"></label></th>
                        <th><label data-translate="Créditos"></label></th>
                        <th><label data-translate="Responsable"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->degrees)): ?>
                    <tbody>
                    <?php foreach ($this->degrees as $degree): ?>
                        <tr>
                            ($id, $name, $center, $capacity, $description, $credits, $user)
                            <td><?php echo $degree->getName(); ?></td>
                            <td><?php echo $degree->getCenter()->getName(); ?></td>
                            <td><?php echo $degree->getCapacity(); ?></td>
                            <td><?php echo $degree->getCredits(); ?></td>
                            <td><?php echo $degree->getUser()->getName() . " " . $degree->getUser()->getSurname(); ?></td>
                            <td class="row">
                                <?php if (HavePermission("Degree", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/DegreeController.php?action=show&id=<?php echo $degree->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Degree", "EDIT")) { ?>
                                    <a href="../Controllers/DegreeController.php?action=edit&id=<?php echo $degree->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Degree", "DELETE")) { ?>
                                    <a href="../Controllers/DegreeController.php?action=delete&id=<?php echo $degree->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna titulación">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalDegrees,
                    "Degree") ?>

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
