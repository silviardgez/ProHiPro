<?php
include_once '../Functions/HavePermission.php';

class TutorialShowAllView
{
    private $tutorials;
    private $itemsPerPage;
    private $currentPage;
    private $totalTutorials;
    private $totalPages;
    private $stringToSearch;
    private $searching;

    function __construct($tutorials, $itemsPerPage = NULL, $currentPage = NULL, $totalTutorials = NULL, $toSearch = NULL, $searching=false)
    {
        $this->tutorials = $tutorials;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalTutorials = $totalTutorials;
        $this->totalPages = ceil($totalTutorials / $itemsPerPage);
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
                <h1 class="h2" data-translate="Listado de tutorías"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/TutorialController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/TutorialController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Tutorial", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/TutorialController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir tutoría"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Profesor"></label></th>
                        <th><label data-translate="Espacio"></label></th>
                        <th><label data-translate="Horas"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->tutorials)): ?>
                    <tbody>
                    <?php foreach ($this->tutorials as $tutorial): ?>
                            <td><?php echo $tutorial->getTeacher()->getUser()->getName() . " " .
                                    $tutorial->getTeacher()->getUser()->getSurname() ;?></td>
                            <td><?php echo $tutorial->getSpace()->getName() ;?></td>
                            <td><?php echo $tutorial->getTotalHours() ;?></td>
                            <td class="row">
                                <?php if (HavePermission("Tutorial", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/TutorialController.php?action=show&id=<?php echo $tutorial->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Tutorial", "EDIT")) { ?>
                                    <a href="../Controllers/TutorialController.php?action=edit&id=<?php echo $tutorial->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Tutorial", "DELETE")) { ?>
                                    <a href="../Controllers/TutorialController.php?action=delete&id=<?php echo $tutorial->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna tutoría.">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalTutorials,
                    "Tutorial") ?>

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
