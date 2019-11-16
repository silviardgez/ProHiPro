<?php

include_once '../Functions/HavePermission.php';

class FunctionalityShowAllView
{
    private $functionalities;
    private $itemsPerPage;
    private $currentPage;
    private $totalFunctionalities;
    private $totalPages;
    private $stringToSearch;

    function __construct($functionalitiesData, $itemsPerPage = NULL, $currentPage = NULL, $totalFunctionalities = NULL, $toSearch = NULL)
    {
        $this->functionalities = $functionalitiesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalFunctionalities = $totalFunctionalities;
        $this->totalPages = ceil($totalFunctionalities / $itemsPerPage);
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de funcionalidades"></h1>
                <!-- Search -->
                <form class="row" action='../Controllers/FunctionalityController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/FunctionalityController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("UserRole", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../Controllers/FunctionalityController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir funcionalidad"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th data-translate="Id funcionalidad"></th>
                        <th data-translate="Nombre"></th>
                        <th data-translate="Descripción"></th>
                        <th class="actions-row" data-translate="Acciones"></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->functionalities)): ?>
                    <tbody>
                    <?php foreach ($this->functionalities as $functionality): ?>
                        <tr>
                            <td><?php echo $functionality->getId() ?></td>
                            <td><?php echo $functionality->getName() ?></td>
                            <td><?php echo $functionality->getDescription() ?></td>
                            <td class="row">
                                <?php if (HavePermission("Functionality", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/FunctionalityController.php?action=show&id=<?php echo $functionality->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Functionality", "EDIT")) { ?>
                                    <a href="../Controllers/FunctionalityController.php?action=edit&id=<?php echo $functionality->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Functionality", "DELETE")) { ?>
                                    <a href="../Controllers/FunctionalityController.php?action=delete&id=<?php echo $functionality->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna funcionalidad."></p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalFunctionalities,
                    "Functionality"); ?>

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