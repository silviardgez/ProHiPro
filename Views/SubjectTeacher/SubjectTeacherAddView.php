<?php
class SubjectTeacherAddView {

    private $teachers;
    private $subject;

    function __construct($teachers, $subject){
        $this->subject = $subject;
        $this->teachers = $teachers;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/SubjectTeacherValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Asignar profesor"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/SubjectTeacherController.php?subject_id=<?php echo $this->subject ?>" data-translate="Volver"></a>
            </div>
            <form id="subjectTeacherForm" action='../Controllers/SubjectTeacherController.php?action=add&subject_id=<?php echo $this->subject ?>'
                  method='POST' onsubmit="return areSubjectTeacherFieldsCorrect()">
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>"><?php echo $teacher->getUser()->getName()." ".
                                    $teacher->getUser()->getSurname() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div id="hours-div" class="form-group">
                    <label for="hours" data-translate="Horas"></label>
                    <input type="number" class="form-control" id="hours" name="hours" data-translate="Introducir horas"
                           maxlength="2" required oninput="checkHoursSubjectTeacher(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>

        <?php
    }
}
?>
