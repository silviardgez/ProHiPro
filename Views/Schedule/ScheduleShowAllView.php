<?php
include_once '../Functions/HavePermission.php';

class ScheduleShowAllView
{
    private $schedules;
    private $itemsPerPage;
    private $currentPage;
    private $totalSchedules;
    private $totalPages;
    private $stringToSearch;
    private $subject;

    function __construct($scheduleData, $itemsPerPage = NULL, $currentPage = NULL, $totalSchedules = NULL, $toSearch = NULL, $subject = NULL)
    {
        $this->schedules = $scheduleData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalSchedules = $totalSchedules;
        $this->totalPages = ceil($totalSchedules / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->subject = $subject;
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
                <h1 class="h2" data-translate="Horarios de la asignatura %<?php echo $this->subject->getAcronym() ?>%"></h1>

                <!-- Search -->
                <form class="row" action='../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId()?>' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId()?>">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (HavePermission("Schedule", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId()?>&action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir horario"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Grupo"></label></th>
                        <th><label data-translate="Día"></label></th>
                        <th><label data-translate="Hora de inicio"></label></th>
                        <th><label data-translate="Hora de fin"></label></th>
                        <th><label data-translate="Aula"></label></th>
                        <th><label data-translate="Profesor"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->schedules)): ?>
                    <tbody>
                    <?php foreach ($this->schedules as $schedule): ?>
                        <tr>
                            <td><?php echo $schedule->getSubjectGroup()->getSubject()->getAcronym() . "_" .
                                $schedule->getSubjectGroup()->getName();?></td>
                            <td><?php echo date("d-m-Y", strtotime($schedule->getDay())) ;?></td>
                            <td><?php echo date("H:i", strtotime($schedule->getStartHour())) ;?></td>
                            <td><?php echo date("H:i", strtotime($schedule->getEndHour())) ;?></td>
                            <td><?php echo $schedule->getSpace()->getName() ;?></td>
                            <td><?php echo $schedule->getTeacher()->getUser()->getName() . " " .
                                    $schedule->getTeacher()->getUser()->getSurname() ;?></td>
                            <td class="row">
                                <?php if (HavePermission("Schedule", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=show&id=<?php echo $schedule->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Schedule", "EDIT")) { ?>
                                    <a href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=edit&id=<?php echo $schedule->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Schedule", "DELETE")) { ?>
                                    <a href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=delete&id=<?php echo $schedule->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún horario para esta asignatura">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalSchedules,
                    "Schedule", "../Controllers/ScheduleController.php?subject=" . $this->subject->getId() . "&")?>

                <a type="button" class="btn btn-success" data-translate="Editar por rango" style="margin-top: .7rem"
                   href="../Controllers/ScheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=editByRange"></a>

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
