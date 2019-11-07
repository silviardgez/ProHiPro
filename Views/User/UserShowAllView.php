<?php
class UserShowAllView {
private $users;

function __construct($usersData){
    $this->users = $usersData;
    $this->render();
}
function render(){
?>
<head><link rel="stylesheet" href="../CSS/default.css" /></head>
<main role="main" class="margin-main ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
        <h1 class="h2">Listado de usuarios</h1>
        <a class="btn btn-success" role="button" href="../Controllers/UserController.php?action=add">
            <span data-feather="plus"></span> Añadir usuario</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Login</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
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
            <p> No se ha obtenido ningún usuario. </p>
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