<?php
class UniversityAddView {
    private $academicCourses;

    function __construct($academicCourses){
        $this->academicCourses = $academicCourses;
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
                <h1 class="h2" data-translate="Insertar universidad"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/UniversityController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../Controllers/UniversityController.php?action=add' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre">
                </div>
                <div class="form-group">
                    <label for="academic_course_id" data-translate="Curso académico"></label>
                    <select class="form-control" id="academic_course_id" name="academic_course_id"?>
                        <?php foreach ($this->academicCourses as $academicCourse): ?>
                            <option value="<?php echo $academicCourse->getId() ?>"><?php echo $academicCourse->getAcademicCourseAbbr() ?></option>
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
