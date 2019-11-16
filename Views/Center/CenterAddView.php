<?php
class CenterAddView {
    private $universities;

    function __construct($universitiesData){
        $this->universities = $universitiesData;
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
                <h1 class="h2" data-translate="Insertar centro"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/CenterController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/CenterController.php?action=add' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre">
                </div>
                <div class="form-group">
                    <label for="university_id" data-translate="Universidad"></label>
                    <select class="form-control" id="university_id" name="university_id">
                        <?php foreach ($this->universities as $university): ?>
                            <option value="<?php echo $university->getId() ?>"><?php echo $university->getName() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location" data-translate="Introducir localización">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>
