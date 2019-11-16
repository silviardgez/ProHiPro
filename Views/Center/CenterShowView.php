<?php
class CenterShowView {
    private $center;

    function __construct($centerData){
        $this->center = $centerData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Centro '%<?php echo $this->center->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/CenterController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/CenterController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->center->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="university_id" data-translate="Universidad"></label>
                    <input type="text" class="form-control" id="university_id" name="university_id" data-translate="Introducir universidad"
                           value="<?php echo $this->center->getUniversity()->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location" data-translate="Introducir localización"
                           value="<?php echo $this->center->getLocation() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}
?>
