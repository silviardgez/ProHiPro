<?php
class UserRoleEditView {
    private $userRole;
    private $users;
    private $roles;
    function __construct($userRole,$userData,$roleData){
        $this->userRole = $userRole;
        $this->users = $userData;
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
                <h1 class="h2" data-translate="Acción"> <?php echo $this->userRole->getIdUserRole() ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UserRoleController.php"><p data-translate="Volver"></p></a>
            </div>
            <form name = "EDIT" action='../Controllers/UserRoleController.php?action=edit&IdUserRole=<?php echo $this->userRole->getIdUserRole() ?>' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Usuario"></label>
                    <select class="form-control" id="login" name="login">
                        <?php foreach($this->users as $user): ?>
                            <option value="<?php echo $user->getLogin()?>" <?php if($user->getLogin() == $this->userRole->getLogin()): echo 'selected="selected"'; endif;?>><?php echo $user->getLogin()?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Rol"></label>
                    <select class="form-control" id="idRole" name="idRole">
                        <?php foreach($this->roles as $role): ?>
                            <option value="<?php echo $role->getIdRole()?>" <?php if($role->getIdRole() == $this->userRole->getIdRole()): echo 'selected="selected"'; endif;?>><?php echo $role->getName()?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>

<script>
    translatePage(getCookie("language-selected"));
</script>
