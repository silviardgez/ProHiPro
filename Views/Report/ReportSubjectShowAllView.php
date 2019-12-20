<?php
include_once '../Functions/HavePermission.php';

class SubjectShowAllView
{
    private $subjects;


    function __construct($subjects)
    {
        $this->subjects = $subjects;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/table.css"/>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de asignaturas"></h1>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Código"></label></th>
                        <th><label data-translate="Acrónimo"></label></th>
                        <th><label data-translate="Contenido"></label></th>
                        <th><label data-translate="Tipo"></label></th>
                        <th><label data-translate="Curso"></label></th>
                        <th><label data-translate="Cuatrimestre"></label></th>
                        <th><label data-translate="Créditos"></label></th>
                        <th><label data-translate="Titulación"></label></th>

                    </tr>
                    </thead>
                    <?php if (!empty($this->subjects)): ?>
                    <tbody>
                    <?php foreach ($this->subjects as $subject): ?>
                        <tr>
                            <td><?php echo $subject->getCode() ;?></td>
                            <td><?php echo $subject->getAcronym(); ?></td>
                            <td><?php echo $subject->getContent() ;?></td>
                            <td><?php echo $subject->getType() ;?></td>
                            <td><?php echo $subject->getCourse() ;?></td>
                            <td><?php echo $subject->getQuarter() ;?></td>
                            <td><?php echo $subject->getCredits() ;?></td>
                            <td><?php echo $subject->getDegree()->getName() ;?></td>


                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna asignatura.">. </p>
                <?php endif; ?>


                <form class="row" action='../Functions/ExportCSV.php' method='POST'>
                    <input type="hidden" name="data" value="<?php echo base64_encode(serialize($this->subjects))?>"/>
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Descargar CSV"></button>
                </form>

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
