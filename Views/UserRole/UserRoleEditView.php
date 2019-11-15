<?php
class UserRoleEditView {
    private $userRole;
    private $users;
    private $roles;
    function __construct($userRole, $userData, $roleData){
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
                <h1 class="h2" data-translate="Usuario-rol '%<?php echo $this->userRole->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UserRoleController.php"><p data-translate="Volver"></p></a>
            </div>
            <form name = "EDIT" action='../Controllers/UserRoleController.php?action=edit&id=<?php echo $this->userRole->getId() ?>' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Usuario"></label>
                    <select class="form-control" id="user_id" name="user_id">
                        <?php foreach($this->users as $user): ?>
                            <option value="<?php echo $user->getId()?>"
                                <?php if($user->getId() == $this->userRole->getUser()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $user->getId() ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="role_id" data-translate="Rol"></label>
                    <select class="form-control" id="role_id" name="role_id">
                        <?php foreach($this->roles as $role): ?>
                            <option value="<?php echo $role->getId()?>"
                                <?php if($role->getId() == $this->userRole->getRole()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $role->getName() ?>
                            </option>
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