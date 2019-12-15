<?php
include_once '../Functions/HavePermission.php';

class SubjectShowAllView
{
    private $subjects;
    private $itemsPerPage;
    private $currentPage;
    private $totalSubjects;
    private $totalPages;
    private $stringToSearch;
    private $searching;
    private $departmentOwner;

    function __construct($subjects, $itemsPerPage = NULL, $currentPage = NULL, $totalSubjects = NULL, $toSearch = NULL, $searching=false, $departmentOwner=false)
    {
        $this->subjects = $subjects;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalSubjects = $totalSubjects;
        $this->totalPages = ceil($totalSubjects / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->searching=$searching;
        $this->departmentOwner=$departmentOwner;
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

                <!-- Search -->
                <form class="row" action='../Controllers/SubjectController.php' method='POST'>
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>
                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/SubjectController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php elseif($this->departmentOwner):
                    if (HavePermission("Subject", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../Controllers/SubjectController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir asignatura"></p>
                        </a>
                    <?php endif; endif; ?>

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
                        <th><label data-translate="Profesor responsable"></label></th>
                        <?php
							if (HavePermission("Schedule", "SHOWALL")):
						?>
                        <th><label data-translate="Horarios"></label></th>
                        <?php endif; ?>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
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
                            <?php if(!empty($subject->getTeacher()->getUser())): ?>
                                <td><?php echo $subject->getTeacher()->getUser()->getName() . " " .
                                        $subject->getTeacher()->getUser()->getSurname() ;?></td>
                            <?php else:?>
                                <td data-translate="No asignado"></td>
                            <?php endif; ?>
                            <?php
							    if (HavePermission("Schedule", "SHOWALL")):
						    ?>
                            <td class="btn-schedule"><a href="../Controllers/ScheduleController.php?subject=<?php echo $subject->getId() ?>">
                                    <i class="fas fa-calendar-alt"></i></a></td>
                            <?php endif; ?>
                            <td class="row btn-subject-actions">
                                <?php if (HavePermission("Subject", "SHOWCURRENT")) { ?>
                                    <a href="../Controllers/SubjectController.php?action=show&id=<?php echo $subject->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (HavePermission("Subject", "EDIT") && ($this->departmentOwner || (!empty($subject->getTeacher()->getUser())  && $subject->getTeacher()->getUser()->getLogin() == $_SESSION['login']))) { ?>
                                    <a href="../Controllers/SubjectController.php?action=edit&id=<?php echo $subject->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Subject", "DELETE") && ($this->departmentOwner || (!empty($subject->getTeacher()->getUser()) && $subject->getTeacher()->getUser()->getLogin() == $_SESSION['login']))) { ?>
                                    <a href="../Controllers/SubjectController.php?action=delete&id=<?php echo $subject->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                                <a href="../Controllers/SubjectTeacherController.php?subject_id=<?php echo $subject->getId() ?>">
                                    <i class="fas fa-chalkboard-teacher"></i></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna asignatura.">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalSubjects,
                    "Subject") ?>

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
