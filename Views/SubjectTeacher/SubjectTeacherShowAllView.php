<?php
include_once '../Functions/HavePermission.php';

class SubjectTeacherShowAllView
{
    private $subjectTeachers;
    private $itemsPerPage;
    private $currentPage;
    private $totalTeachers;
    private $totalPages;
    private $stringToSearch;
    private $subject;
    private $permission;

    function __construct($subjectTeachers, $itemsPerPage = NULL, $currentPage = NULL, $totalTeachers = NULL, $toSearch = NULL, $subject = NULL, $permission=false)
    {
        $this->subjectTeachers = $subjectTeachers;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalTeachers = $totalTeachers;
        $this->totalPages = ceil($totalTeachers / $itemsPerPage);
        $this->stringToSearch = $toSearch;
        $this->subject = $subject;
        $this->permission=$permission;
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
                <h1 class="h2"
                    data-translate="Profesores de %<?php echo $this->subject->getCode(); ?>%"></h1>

                <?php if (HavePermission("SubjectTeacher", "ADD") && $this->permission): ?>
                    <a class="btn btn-success btn-subject" role="button"
                       href="../Controllers/SubjectTeacherController.php?action=add&subject_id=<?php echo $this->subject->getId(); ?>">
                        <span data-feather="plus"></span>
                        <p data-translate="Asignar profesor"></p>
                    </a>
                <?php endif; ?>
                <a class="btn btn-primary" role="button" href="../Controllers/SubjectController.php">
                    <p data-translate="Volver"></p>
                </a>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Profesor"></label></th>
                        <th><label data-translate="Horas"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->subjectTeachers)): ?>
                    <tbody>
                    <?php foreach ($this->subjectTeachers as $subjectTeacher): ?>
                        <tr>
                            <td><?php echo $subjectTeacher->getTeacher()->getUser()->getName() . " " . $subjectTeacher->getTeacher()->getUser()->getSurname(); ?></td>
                            <td><?php echo $subjectTeacher->getHours() ?></td>
                            <td class="row">
                                <?php if (HavePermission("Center", "EDIT")) { ?>
                                    <a href="../Controllers/SubjectTeacherController.php?action=edit&id=<?php echo $subjectTeacher->getId() ?>&subject_id=<?php echo $subjectTeacher->getSubject()->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (HavePermission("Center", "DELETE")) { ?>
                                    <a href="../Controllers/SubjectTeacherController.php?action=delete&id=<?php echo $subjectTeacher->getId() ?>&subject_id=<?php echo $subjectTeacher->getSubject()->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún profesor">. </p>
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
