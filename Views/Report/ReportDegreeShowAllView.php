<?php
include_once '../Functions/HavePermission.php';

class ReportDegreeShowAllView
{
    private $universities;

    function __construct($universitiesData)
    {
        $this->universities = $universitiesData;
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
                <h1 class="h2" data-translate="Listado de titulaciones"></h1>


            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Centro"></label></th>
                        <th><label data-translate="Capacidad"></label></th>
                        <th><label data-translate="Descripción"></label></th>
                        <th><label data-translate="Créditos"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->universities)): ?>
                    <tbody>
                    <?php foreach ($this->universities as $university): ?>
                        <tr>
                            <td><?php echo $university->getName() ;?></td>
                            <td><?php echo $university->getCenter();?></td>
                            <td><?php echo $university->getCapacity() ;?></td>
                            <td><?php echo $university->getDescription() ;?></td>
                            <td><?php echo $university->getCredits() ;?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningun resultado">. </p>
                <?php endif; ?>

                <form class="row" action='../Functions/ExportCSV.php' method='POST'>
                    <input type="hidden" name="data" value="<?php echo base64_encode(serialize($this->universities))?>"/>
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Descargar csv"></button>
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
