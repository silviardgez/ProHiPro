<?php
include_once '../Functions/HavePermission.php';

class UserShowAllView
{
    private $users;
    private $itemsPerPage;
    private $currentPage;
    private $totalUsers;
    private $totalPages;
    private $stringToSearch;

    function __construct($usersData, $itemsPerPage, $currentPage, $totalUsers, $stringToSearch)
    {
        $this->users = $usersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalUsers = $totalUsers;
        $this->totalPages = ceil($totalUsers / $itemsPerPage);
        $this->stringToSearch = $stringToSearch;
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
                <h1 class="h2" data-translate="Listado de usuarios"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/UserController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if ($this->stringToSearch != null && $this->stringToSearch != ''): ?>
                    <?php echo "<a class=\"btn btn-primary\" role=\"button\" href=\"../Controllers/UserController.php\" data-translate=\"Volver\"></a>"; ?>
                <?php else:
                    if (HavePermission("User", "ADD")):
                        echo "<a class=\"btn btn-success\" role=\"button\" href=\"../Controllers/UserController.php?action=add\">
            <span data-feather=\"plus\"></span><p class=\"btn-show-view\" data-translate=\"Añadir usuario\"></p></a>"; ?>
                    <?php endif; endif; ?>

            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th data-translate="Login"></th>
                        <th data-translate="Nombre"></th>
                        <th data-translate="Apellido"></th>
                        <th data-translate="Email"></th>
                        <th class="actions-row" data-translate="Acciones"></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->users)): ?>
                    <tbody>
                    <?php foreach ($this->users as $user): ?>
                        <tr>
                            <td><?php echo $user->getLogin() ?></td>
                            <td><?php echo $user->getName() ?></td>
                            <td><?php echo $user->getSurname() ?></td>
                            <td><?php echo $user->getEmail() ?></td>
                            <td class="row">
                                <? if (HavePermission("User", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/UserController.php?action=show&login=<?php echo $user->getLogin() ?>">
                                        <span data-feather="eye"></span></a>
                                <? }
                                if (HavePermission("User", "EDIT")) { ?>
                                    <a href="../Controllers/UserController.php?action=edit&login=<?php echo $user->getLogin() ?>">
                                        <span data-feather="edit"></span></a>
                                <? }
                                if (HavePermission("User", "DELETE")) { ?>
                                    <a href="../Controllers/UserController.php?action=delete&login=<?php echo $user->getLogin() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <? } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún usuario">.</p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalUsers,
                    "User") ?>
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
