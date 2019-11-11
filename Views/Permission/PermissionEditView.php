<?php
class PermissionEditView {
    private $permission;
    private $roles;
    private $funcAction;
    private $actions;
    private $functionalities;
    function __construct($permission,$roleData, $funcActionData,$actionsData,$functionalitiesData){
        $this->permission = $permission;
        $this->roles = $roleData;
        $this->funcAction = $funcActionData;
        $this->actions = $actionsData;
        $this->functionalities = $functionalitiesData;
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
                <h1 class="h2"><label data-translate="Permiso"></label> <?php echo $this->permission->getIdPermission() ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/PermissionController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/PermissionController.php?action=edit&IdPermission=<?php echo $this->permission->getIdPermission() ?>' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Rol"></label>
                    <select class="form-control" id="idRole" name="idRole">
                        <?php foreach ($this->roles as $role): ?>
                            <option value="<?php echo $role->getIdRole()?>" <?php if($role->getIdRole()==$this->permission->getIdRole()): echo 'selected="selected"'; endif;?>><?php echo $role->getName() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Permiso"></label>
                    <select class="form-control" id="idFuncAction" name="idFuncAction">
                        <?php foreach($this->funcAction as $funcAction): ?>
                            <option value="<?php echo $funcAction->getIdFuncAction()?>" <?php if($funcAction->getIdFuncAction() == $this->permission->getIdFuncAction()): echo 'selected="selected"'; endif;?>>
                            <?php foreach ($this->actions as $action): ?>
                                <?php foreach ($this->functionalities as $func): ?>
                                    <?php if ($funcAction->getIdAction() == $action->getIdAction()): ?>
                                        <?php if($funcAction->getIdFunctionality() == $func->getIdFunctionality()): ?>
                                           <?php echo $action->getName()." - ".$func->getName(); ?>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endforeach;?>
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

<script>
    translatePage(getCookie("language-selected"));
</script>
