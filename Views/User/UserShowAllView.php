<?php
class UserShowAllView {
private $users;
private $itemsPerPage;
private $currentPage;
private $totalUsers;
private $totalPages;
private $stringToSearch;

function __construct($usersData, $itemsPerPage, $currentPage, $totalUsers, $stringToSearch){
    $this->users = $usersData;
    $this->itemsPerPage = $itemsPerPage;
    $this->currentPage = $currentPage;
    $this->totalUsers = $totalUsers;
    $this->totalPages = ceil($totalUsers/$itemsPerPage);
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
        <h1 class="h2" data-translate="Listado de usuarios"></h1>

        <!-- Search -->
        <form class="row" action='../Controllers/UserController.php' method='POST'>
            <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
        </form>

        <a class="btn btn-success" role="button" href="../Controllers/UserController.php?action=add">
            <span data-feather="plus"></span><p class="btn-show-view" data-translate="Añadir usuario"></p></a>
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
            <?php if(!empty($this->users)):?>
            <tbody>
                <?php foreach ($this->users as $user): ?>
                <tr>
                    <td><?php echo $user->getLogin() ?></td>
                    <td><?php echo $user->getName() ?></td>
                    <td><?php echo $user->getSurname() ?></td>
                    <td><?php echo $user->getEmail() ?></td>
                    <td class="row">
                        <a href="../Controllers/UserController.php?action=show&login=<?php echo $user->getLogin()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/UserController.php?action=edit&login=<?php echo $user->getLogin()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/UserController.php?action=delete&login=<?php echo $user->getLogin()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p data-translate="No se ha obtenido ningún usuario">.</p>
            <?php endif; ?>
    </div>

    <div class="row">
    <!-- Search -->
    <a class="btn btn-primary button-specific-search" role="button"
       href="../Controllers/UserController.php?action=search">
        <span data-feather="search"></span><p class="btn-show-view" data-translate="Búsqueda específica"></p></a>

    <!-- Pagination -->
    <label class="label-pagination" data-translate="Usuarios por página"></label>
    <select class="form-control items-page" id="items-page-select"
            onchange="selectChange(this)">
        <option value="5" <?php if ($this->itemsPerPage == 5) echo "selected" ?>>5</option>
        <option value="10" <?php if ($this->itemsPerPage == 10) echo "selected" ?>>10</option>
        <option value="15" <?php if ($this->itemsPerPage == 15) echo "selected" ?>>15</option>
        <option value="20" <?php if ($this->itemsPerPage == 20) echo "selected" ?>>20</option>
    </select>
    <?php if ($this->totalPages > 1): ?>
    <nav aria-label="...">
        <ul class="pagination">
            <?php if ($this->currentPage == 1): ?>
            <li class="page-item disabled">
            <?php else: ?>
            <li class="page-item">
            <?php endif; ?>
                <a class="page-link" href="../Controllers/UserController.php?currentPage=<?php echo $this->currentPage-1?>">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $this->totalPages; $i++): ?>
                <?php if ($this->currentPage == $i): ?>
                <li class="page-item active">
                <?php else: ?>
                <li class="page-item">
                <?php endif; ?>
                        <a class="page-link"
                        href="../Controllers/UserController.php?currentPage=<?php echo $i ?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                            <?php echo $i?></a>
                </li>
            <?php endfor; ?>
            <?php if ($this->currentPage == $this->totalPages): ?>
            <li class="page-item disabled">
            <?php else: ?>
            <li class="page-item">
            <?php endif; ?>
                <a class="page-link" href="../Controllers/UserController.php?currentPage=<?php echo $this->currentPage+1?>">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
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
