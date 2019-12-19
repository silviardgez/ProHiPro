<?php
class ReporDegreeSearchView {
    private $universities;
    private $centers;

    function __construct($universities, $centers){
        $this->universities = $universities;
        $this->centers = $centers;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/UniversityValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Búsqueda de centros"></h1>
            </div>
            <form id="universitySearchForm" action='../Controllers/ReportController.php?action=search' method='POST'">
            <div class="form-group">
                <label for="academic_course_id" data-translate="Universidad"></label>
                <select class="form-control" id="university" name="university"?>
                    <option data-translate="Introducir universidad" value=""></option>
                    <?php foreach ($this->universities as $university): ?>
                        <option value="<?php echo $university->getId() ?>"><?php echo $university->getName() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="academic_course_id" data-translate="Centro"></label>
                <select class="form-control" id="center" name="center"?>
                    <option data-translate="Insertar centro" value=""></option>
                    <?php foreach ($this->centers as $center): ?>
                        <option value="<?php echo $center->getId() ?>"><?php echo $center->getName() ?></option>
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
<?php
