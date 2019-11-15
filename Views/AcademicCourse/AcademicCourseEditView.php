<?php
class AcademicCourseEditView {
    private $academicCourse;
    function __construct($academicCourseData){
        $this->academicCourse = $academicCourseData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
            <script src="../JS/Validations/AcademicCourseValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Curso académico %<?php echo $this->academicCourse->getAcademicCourseAbbr() ?>%"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/AcademicCourseController.php"><p data-translate="Volver"></p></a>
            </div>
            <form id="academicCourseEditForm" name = "EDIT" action='../Controllers/AcademicCourseController.php?action=edit' method='POST' onsubmit="return areAcademicCourseEditFieldsCorrect()">
                <div class="form-group">
                    <label for="IdAcademicCourse" data-translate="Identificador"></label>
                    <input type="hidden" name="id" value="<?php echo $this->academicCourse->getId() ?>" >
                    <input type="text" class="form-control" id="academicCourseAbbr" name="academicCourseAbbr"
                           value="<?php echo $this->academicCourse->getAcademicCourseAbbr() ?>" readonly>
                </div>
                <div id="start-year-div" class="form-group">
                    <label for="start_year" data-translate="Año de inicio"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="start_year" name="start_year"
                           value="<?php echo $this->academicCourse->getStartYear() ?>" oninput="checkStartYearEmptyAcademicCourse(this)" required >
                </div>
                <div id="end-year-div" class="form-group">
                    <label for="end_year" data-translate="Año de fin"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="end_year" name="end_year"
                           value="<?php echo $this->academicCourse->getEndYear() ?>" oninput="checkEndYearEmptyAcademicCourse(this)" required >
                </div>

                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <div id="capaVentana" style="visibility: hidden;position:fixed;position: fixed;padding: 0px;right: 0%;top:40%;z-index:2">
            <table  width="250px" style="border:1px solid red;padding:0px;">
                <tr>
                    <td colspan="2" style="background-color:red" width="250px">
                        <font style="font-size:24px;color:white">ALERTA</font>
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="background-color:white;" >
                        <div id="miDiv" style="color:black;"></div>
                    </td>
                </tr>
                <tr style="background-color:white">
                    <td >
                        <form name="formError">
                            <button type="button"  name="bAceptar"  value="Aceptar" onclick="cerrarVentana()" ><img src="../Views/icon/confirmar.png" height="32" width="32"  /></button>
                        </form>
                    </td>
                </tr>

            </table>
        </div>

        <div id="capaFondo1" style="visibility:hidden;position: fixed;padding: 0px;width: 100%;height: 100%;top:0;left:0;z-index:1;background-color: rgba(1,,1,1,0.5)"></div>
        <?php
    }
}
?>
