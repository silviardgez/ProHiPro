<?php
class UniversityShowView {
    private $university;

    function __construct($universityData){
        $this->university = $universityData;
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
                <h1 class="h2" data-translate="Universidad '%<?php echo $this->university->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UniversityController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/UniversityController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->university->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="academic_course_id" data-translate="Curso académico"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir curso académico"
                           value="<?php echo $this->university->getAcademicCourse()->getAcademicCourseAbbr() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}
?>
