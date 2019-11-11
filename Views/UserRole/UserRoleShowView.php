<?php
class UserRoleShowView {
private $userRole;
private $roles;
    function __construct($userRoleData, $roleData){
        $this->userRole = $userRoleData;
        $this->roles = $roleData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2"><p data-translate="Rol"></p></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UserRoleController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->userRole)): ?>
            <form>
                <div class="form-group">
                    <label for="name" data-translate="Usuario"></label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?php echo $this->userRole->getLogin(); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Rol"></label>
                    <?php foreach ($this->roles as $rol): ?>
                        <?php if ($rol->getIdRole() == $this->userRole->getIdRole()):?>
                        <input type="text" class="form-control" id="description" name="description"
                               value="<?php echo $rol->getName() ?>" readonly>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El rol no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

<script>
    translatePage(getCookie("language-selected"));
</script>
