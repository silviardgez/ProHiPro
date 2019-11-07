<?php
class FunctionalityShowView {
private $functionality;
    function __construct($functionalityData){
        $this->functionality = $functionalityData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/add_style.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2">Funcionalidad <?php echo $_REQUEST['IdFunctionality'] ?></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/FunctionalityController.php">Volver</a>
            </div>
            <?php if(!is_null($this->functionality)): ?>
            <form>
                <div class="form-group">
                    <label for="IdFunctionality">IdFunctionality</label>
                    <input type="text" class="form-control" id="IdFunctionality" name="IdFunctionality"
                           value="<?php echo $this->functionality->getIdFunctionality() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->functionality->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->functionality->getDescription() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
            La funcionalidad no existe.
            <?php endif; ?>
        </main>
        <?php
    }
}
?>