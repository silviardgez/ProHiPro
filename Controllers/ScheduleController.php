<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Schedule/ScheduleDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Group/GroupDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Schedule/ScheduleShowAllView.php';
include_once '../Views/Schedule/ScheduleAddView.php';
include_once '../Views/Schedule/ScheduleShowView.php';
include_once '../Views/Schedule/ScheduleEditView.php';
include_once '../Views/Schedule/ScheduleEditByRangeView.php';
include_once '../Views/Schedule/ScheduleSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$scheduleDAO = new ScheduleDAO();
$teacherDAO = new TeacherDAO();
$subjectGroupDAO = new GroupDAO();
$subjectDAO = new SubjectDAO();
$spaceDAO = new SpaceDAO();


//Data required
$teacherData = $teacherDAO->showAll();
$spaceData = $spaceDAO->showAll();
$subjectGroupData = $subjectGroupDAO->showAll();

if(isset($_REQUEST["subject"])) {
    $subjectId = $_REQUEST["subject"];
    $subject = $subjectDAO->show("id", $subjectId);
}

$schedulePrimaryKey = "id";
$value = $_REQUEST[$schedulePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Schedule", "ADD")) {
            if (!isset($_POST["submit"])) {
                        new ScheduleAddView($teacherData, $spaceData, $subjectGroupData);
                    } else {
                        try {
                            $weekday = "";
                            $startDate=strtotime($_POST["start_day"]);
                            $endDate=strtotime($_POST["end_day"]);
                            $startHour=strtotime($_POST["start_hour"]);
                            $endHour=strtotime($_POST["end_hour"]);
                            $busyTeacher=array();
                            $busySpace=array();
                    $freeSchedule=array();
                    for ($i=$startDate; $i<=$endDate; $i+=86400) {
                        if ($i === $startDate) {
                          $weekday = getWeekday($i);
                        }
                        if ($weekday === getWeekday($i)) {
                            $schedule = new Schedule();
                            $schedule->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                            $schedule->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                            $schedule->setSubjectGroup($subjectGroupDAO->show("id", $_POST["subject_group_id"]));
                            $schedule->setDay(date("Y-m-d", $i));
                            $schedule->setStartHour($_POST["start_hour"]);
                            $schedule->setEndHour($_POST["end_hour"]);
                            $isTeacherUsed = $scheduleDAO->checkIfTeacherIsUsed($_POST["teacher_id"], date("Y-m-d", $i), date("H:i:s", $startHour),
                                date("H:i:s", $endHour));
                            $isSpaceUsed = $scheduleDAO->checkIfSpaceIsUsed($_POST["teacher_id"], date("Y-m-d", $i), date("H:i:s", $startHour),
                                date("H:i:s", $endHour));

                            if ($isTeacherUsed || $isSpaceUsed) {
                                if ($isSpaceUsed) {
                                    array_push($busySpace, $schedule);
                                }
                                if ($isTeacherUsed) {
                                    array_push($busyTeacher, $schedule);
                                }
                            } else {
                                array_push($freeSchedule, $schedule);
                            }
                        }
                    }
                    $busyTeacherString = "";
                    $busySpaceString = "";
                    if(!empty($busyTeacher)) {
                        foreach ($busyTeacher as $scheduleTeacher) {
                            if($busyTeacherString === "") {
                                $busyTeacherString .= "El profesor %" . $scheduleTeacher->getTeacher()->getUser()->getName() .
                                    " " . $scheduleTeacher->getTeacher()->getUser()->getSurname() . "% está ocupado los días %" .
                                    $scheduleTeacher->getDay();
                            } else {
                                $busyTeacherString .= ", " . $scheduleTeacher->getDay();
                            }
                        }
                        if($busyTeacherString !== "") {
                            $busyTeacherString .= "%";
                        }
                    }
                    if(!empty($busySpace)) {
                        foreach ($busySpace as $scheduleSpace) {
                            if($busySpaceString === "") {
                                $busySpaceString .= "El aula %" . $scheduleSpace->getSpace()->getName() ."% está ocupada los días %" .
                                    $scheduleSpace->getDay();
                            } else {
                                $busySpaceString .= ", " . $scheduleSpace->getDay();
                            }
                        }
                        if($busySpaceString !== "") {
                            $busySpaceString .= "%";
                        }
                    }
                    if($busySpaceString !== "" || $busyTeacherString !== "") {
                        showConfirmationModal($busyTeacherString, $busySpaceString, $freeSchedule, $subjectId, "addConfirmed");
                    } else {
                        addSchedule($freeSchedule);
                        goToShowAllAndShowSuccess("Horario añadido correctamente.");
                    }
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "delete":
        if (HavePermission("Schedule", "DELETE")) {
            $schedule = $scheduleDAO->show($schedulePrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $scheduleDAO->delete($schedulePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Horario eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $scheduleDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar horario", "¿Está seguro de que desea eliminar " .
                        "el horario %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/ScheduleController.php?subject=". $subjectId . "&action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Schedule", "SHOWCURRENT")) {
            try {
                $scheduleData = $scheduleDAO->show($schedulePrimaryKey, $value);
                new ScheduleShowView($scheduleData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if (HavePermission("Schedule", "EDIT")) {
            try {
                $schedule = $scheduleDAO->show($schedulePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new ScheduleEditView($schedule, $teacherData, $spaceData, $subjectGroupData);
                } else {
                    $schedule->setId($value);
                    $schedule->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    $schedule->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $schedule->setSubjectGroup($subjectGroupDAO->show("id", $_POST["subject_group_id"]));
                    $schedule->setDay($_POST["day"]);
                    $schedule->setStartHour($_POST["start_hour"]);
                    $schedule->setEndHour($_POST["end_hour"]);
                    $scheduleDAO->edit($schedule);
                    goToShowAllAndShowSuccess("Horario editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if (HavePermission("Schedule", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new ScheduleSearchView($teacherData, $spaceData, $subjectGroupData);
            } else {
                try {
                    $schedule = new Schedule();
                    if(!empty($_POST["teacher_id"])) {
                        $schedule->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    }
                    if(!empty($_POST["space_id"])) {
                        $schedule->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    }
                    if(!empty($_POST["subject_group_id"])) {
                        $schedule->setSubjectGroup($subjectGroupDAO->show("id", $_POST["subject_group_id"]));
                    }
                    if(!empty($_POST["day"])) {
                        $schedule->setDay($_POST["day"]);
                    }
                    if(!empty($_POST["start_hour"])) {
                        $schedule->setStartHour($_POST["start_hour"]);
                    }
                    if(!empty($_POST["end_hour"])) {
                        $schedule->setEndHour($_POST["end_hour"]);
                    }
                    showAllSearch($schedule);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.");
        }
        break;
    case "addConfirmed":
        addSchedule(unserialize(base64_decode($_POST["schedules_to_insert"])));
        goToShowAllAndShowSuccess("Horario añadido correctamente.");
        break;
    case "editConfirmed":
        editSchedule(unserialize(base64_decode($_POST["schedules_to_insert"])));
        goToShowAllAndShowSuccess("Horario añadido correctamente.");
        break;
    case "editByRange":
        if (HavePermission("Schedule", "EDIT")) {
            if (!isset($_POST["submit"])) {
                new ScheduleEditByRangeView($teacherData, $spaceData, $subjectGroupData);
            } else {
                try {
                    $startDate=strtotime($_POST["start_day"]);
                    $endDate=strtotime($_POST["end_day"]);
                    $group=$_POST["subject_group_id"];
                    if(!empty($_POST["start_hour"])) {
                        $startHour = strtotime($_POST["start_hour"]);
                    }
                    if(!empty($_POST["end_hour"])) {
                        $endHour = strtotime($_POST["end_hour"]);
                    }
                    $busyTeacher=array();
                    $busySpace=array();
                    $schedulesToEdit = $scheduleDAO->getAllSchedulesByRange(date("Y-m-d", $startDate), date("Y-m-d", $endDate), $group);
                    $freeSchedule=array();
                    foreach ($schedulesToEdit as $scheduleToEdit) {
                        if(!empty($_POST["space_id"])) {
                            $scheduleToEdit->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                        }
                        if(!empty($_POST["teacher_id"])) {
                            $scheduleToEdit->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                        }
                        if(!empty($_POST["start_hour"])) {
                            $scheduleToEdit->setStartHour($_POST["start_hour"]);
                        }
                        if(!empty($_POST["end_hour"])) {
                            $scheduleToEdit->setEndHour($_POST["end_hour"]);
                        }

                        $isTeacherUsed = false;
                        $isSpaceUsed = false;

                        $isTeacherUsed = $scheduleDAO->checkIfTeacherIsUsedLessId($scheduleToEdit->getTeacher()->getId(),
                            date("Y-m-d", strtotime($scheduleToEdit->getDay())), date("H:i:s", $startHour),
                            date("H:i:s", $endHour), $scheduleToEdit->getId());

                        $isSpaceUsed = $scheduleDAO->checkIfSpaceIsUsedLessId($scheduleToEdit->getSpace()->getId(),
                            date("Y-m-d", strtotime($scheduleToEdit->getDay())), date("H:i:s", $startHour),
                            date("H:i:s", $endHour), $scheduleToEdit->getId());

                        if ($isTeacherUsed || $isSpaceUsed) {
                            if ($isSpaceUsed) {
                                array_push($busySpace, $scheduleToEdit);
                            }
                            if ($isTeacherUsed) {
                                array_push($busyTeacher, $scheduleToEdit);
                            }
                        } else {
                            array_push($freeSchedule, $scheduleToEdit);
                        }
                    }
                    $busyTeacherString = "";
                    $busySpaceString = "";
                    if(!empty($busyTeacher)) {
                        foreach ($busyTeacher as $scheduleTeacher) {
                            if($busyTeacherString === "") {
                                $busyTeacherString .= "El profesor %" . $scheduleTeacher->getTeacher()->getUser()->getName() .
                                    " " . $scheduleTeacher->getTeacher()->getUser()->getSurname() . "% está ocupado los días %" .
                                    $scheduleTeacher->getDay();
                            } else {
                                $busyTeacherString .= ", " . $scheduleTeacher->getDay();
                            }
                        }
                        if($busyTeacherString !== "") {
                            $busyTeacherString .= "%";
                        }
                    }
                    if(!empty($busySpace)) {
                        foreach ($busySpace as $scheduleSpace) {
                            if($busySpaceString === "") {
                                $busySpaceString .= "El aula %" . $scheduleSpace->getSpace()->getName() ."% está ocupada los días %" .
                                    $scheduleSpace->getDay();
                            } else {
                                $busySpaceString .= ", " . $scheduleSpace->getDay();
                            }
                        }
                        if($busySpaceString !== "") {
                            $busySpaceString .= "%";
                        }
                    }
                    if($busySpaceString !== "" || $busyTeacherString !== "") {
                        showConfirmationModal($busyTeacherString, $busySpaceString, $freeSchedule, $subjectId, "editConfirmed");
                    } else {
                        editSchedule($freeSchedule);
                        goToShowAllAndShowSuccess("Horario editado correctamente.");
                    }
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (HavePermission("Schedule", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $subject = $GLOBALS["subject"];
            $totalSchedules = $GLOBALS["scheduleDAO"]->countTotalSchedules($toSearch);
            $scheduleData = $GLOBALS["scheduleDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new ScheduleShowAllView($scheduleData, $itemsPerPage, $currentPage, $totalSchedules, $toSearch, $subject);
        } catch (DAOException $e) {
            new ScheduleShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message) {
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    successMessage($message);
}

function getWeekday($date) {
    return date('l', $date);
}

function showConfirmationModal($busyTeacherString, $busySpaceString, $freeSchedule, $subjectId, $action) {
    showAll();
    echo '<div id="confirmation-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" data-translate="Error al insertar horario"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p data-translate="' . $busySpaceString . '"></p>
        <p data-translate="' . $busyTeacherString . '"></p>
      </div>
      <div class="modal-footer">
      <form action="../Controllers/ScheduleController.php?subject=' . $subjectId . '&action=' . $action .'" method="POST" style="margin-bottom: 0">
        <input id="array-schedules" type="hidden" name="schedules_to_insert" value=\'' . base64_encode(serialize($freeSchedule)). '\' />
        <button id="confirm-btn" type="submit" class="btn btn-primary"><p style="margin-bottom: 0" data-translate="Ignorar días ocupados e insertar los demás"></p></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><p style="margin-bottom: 0" data-translate="Cancelar todo"></p></button>
      </form>
      </div>
    </div>
  </div>
</div>';
    echo "<script> $('#confirmation-modal').modal('show');</script>";
}

function addSchedule($freeSchedule) {
    foreach ($freeSchedule as $schedule) {
        $GLOBALS["scheduleDAO"]->add($schedule);
    }
}

function editSchedule($freeSchedule) {
    foreach ($freeSchedule as $schedule) {
        $GLOBALS["scheduleDAO"]->edit($schedule);
    }
}