<?php
include_once '../Functions/HavePermission.php';

class UserRoleShowAllView
{
    private $userRoles;
    private $itemsPerPage;
    private $currentPage;
    private $totalUserRoles;
    private $totalPages;
    private $stringToSearch;

    function __construct($userRoleData, $itemsPerPage = NULL, $currentPage = NULL, $totalUserRoles = NULL, $toSearch = NULL)
    {
        $this->userRoles = $userRoleData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalUserRoles = $totalUserRoles;
        $this->totalPages = ceil($totalUserRoles / $itemsPerPage);
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
                <h1 class="h2" data-translate="Listado de asignación de roles a usuarios"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/UserRoleController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/UserRoleController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("UserRole", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../Controllers/UserRoleController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Asignar rol a usuario"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Usuario"></label></th>
                        <th><label data-translate="Rol"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->userRoles)): ?>
                    <tbody>
                    <?php foreach ($this->userRoles as $userRole): ?>
                        <tr>
                            <td><?php echo $userRole->getUser()->getLogin(); ?></td>
                            <td><?php echo $userRole->getRole()->getName(); ?></td>
                            <td class="row">
                                <?php if (HavePermission("UserRole", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/UserRoleController.php?action=show&id=<?php echo $userRole->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("UserRole", "EDIT")) { ?>
                                    <a href="../Controllers/UserRoleController.php?action=edit&id=<?php echo $userRole->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("UserRole", "DELETE")) { ?>
                                    <a href="../Controllers/UserRoleController.php?action=delete&id=<?php echo $userRole->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún rol">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalUserRoles,
                    "UserRole") ?>

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
