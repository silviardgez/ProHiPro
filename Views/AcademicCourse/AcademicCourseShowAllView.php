<?php
class AcademicCourseShowAllView {
private $academicCourse;

function __construct($academicCoursesData){
    $this->academicCourses = $academicCoursesData;
    $this->render();
}
function render(){
?>
<head>
    <link rel="stylesheet" href="../CSS/default.css" />
    <link rel="stylesheet" href="../CSS/table.css" />
</head>
<main role="main" class="margin-main ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
        <h1 class="h2"> <p data-translate="Listado de cursos académicos"></p></h1>
        <a class="btn btn-success" role="button" href="../Controllers/AcademicCourseController.php?action=add">
            <span data-feather="plus" ></span><p data-translate="Añadir curso académico"></p></a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th><label data-translate="Identificador"></th>
                <th><label data-translate="Año de inicio"></th>
                <th><label data-translate="Año de fin"></th>
            </tr>
            </thead>
            <?php if(!empty($this->academicCourses)):?>
            <tbody>
                <?php foreach ($this->academicCourses as $academicCourse): ?>
                <tr>
                    <td><?php echo $academicCourse->getIdAcademicCourse() ?></td>
                    <td><?php echo $academicCourse->getStartYear() ?></td>
                    <td><?php echo $academicCourse->getEndYear() ?></td>
                    <td class="row">
                        <a href="../Controllers/AcademicCourseController.php?action=show&IdAcademicCourse=<?php echo $academicCourse->getIdAcademicCourse()?>">
                            <span data-feather="eye"></span></a>
                        <a href="../Controllers/AcademicCourseController.php?action=edit&IdAcademicCourse=<?php echo $academicCourse->getIdAcademicCourse()?>">
                            <span data-feather="edit"></span></a>
                        <a href="../Controllers/AcademicCourseController.php?action=delete&IdAcademicCourse=<?php echo $academicCourse->getIdAcademicCourse()?>">
                            <span data-feather="trash-2"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <?php else: ?>
            </table>
            <p data-translate="No se ha obtenido ningún año académico">. </p>
            <?php endif; ?>
    </div>
</main>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
<?php
    }
}
?>
