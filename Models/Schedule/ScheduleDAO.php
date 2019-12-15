<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Group/GroupDAO.php';
include_once 'Schedule.php';

class ScheduleDAO
{
    private $defaultDAO;
    private $spaceDAO;
    private $teacherDAO;
    private $subjectGroupDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->teacherDAO = new TeacherDAO();
        $this->subjectGroupDAO = new GroupDAO();
    }

    function showAll()
    {
        $schedule_db = $this->defaultDAO->showAll("schedule");
        return $this->getScheduleFromDB($schedule_db);
    }

    function add($schedule)
    {
        $this->defaultDAO->insert($schedule, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("schedule", $key, $value);
    }

    function show($key, $value)
    {
        $schedule = $this->defaultDAO->show("schedule", $key, $value);
        $space = $this->spaceDAO->show("id", $schedule["space_id"]);
        $teacher = $this->teacherDAO->show("id", $schedule["teacher_id"]);
        $subjectGroup = $this->subjectGroupDAO->show("id", $schedule["subject_group_id"]);
        return new Schedule($schedule["id"], $space, $teacher, $subjectGroup, $schedule["start_hour"],
            $schedule["end_hour"], $schedule["day"]);
    }

    function edit($schedule)
    {
        $this->defaultDAO->edit($schedule, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("schedule");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $schedule_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Schedule(), $stringToSearch);
        return $this->getScheduleFromDB($schedule_db);
    }

    function countTotalSchedules($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new Schedule(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("schedule", $value);
    }

    function checkIfTeacherIsUsed($teacherId, $day, $startHour, $endHour) {
        $sql = "SELECT * FROM SCHEDULE WHERE teacher_id = " . $teacherId . " AND day = '" . $day . "' AND (('" . $startHour . "'> TIME_FORMAT(start_hour, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(end_hour, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(start_hour, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(end_hour, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function checkIfTeacherIsUsedLessId($teacherId, $day, $startHour, $endHour, $id) {
        $sql = "SELECT * FROM SCHEDULE WHERE teacher_id = " . $teacherId . " AND day = '" . $day . "' AND id <>". $id ." AND (('" . $startHour . "'> TIME_FORMAT(start_hour, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(end_hour, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(start_hour, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(end_hour, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function checkIfSpaceIsUsed($spaceId, $day, $startHour, $endHour) {
        $sql = "SELECT * FROM SCHEDULE WHERE space_id = " . $spaceId . " AND day = '" . $day . "' AND (('" . $startHour . "'> TIME_FORMAT(start_hour, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(end_hour, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(start_hour, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(end_hour, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function checkIfSpaceIsUsedLessId($spaceId, $day, $startHour, $endHour, $id) {
        $sql = "SELECT * FROM SCHEDULE WHERE space_id = " . $spaceId . " AND day = '" . $day . "' AND id <>". $id ." AND (('" . $startHour . "'> TIME_FORMAT(start_hour, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(end_hour, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(start_hour, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(end_hour, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function getAllSchedulesByRange($startDay, $endDay, $groupId) {
        $sql = "SELECT * FROM SCHEDULE WHERE subject_group_id = " . $groupId . " AND day between '" . $startDay . "' AND '" . $endDay . "'";
        $data = $this->defaultDAO->getArrayFromSqlQuery($sql);
        return $this->getScheduleFromDB($data);
    }

    private function getScheduleFromDB($schedule_db)
    {
        $schedules = array();
        foreach ($schedule_db as $schedule) {
            $space = $this->spaceDAO->show("id", $schedule["space_id"]);
            $teacher = $this->teacherDAO->show("id", $schedule["teacher_id"]);
            $subjectGroup = $this->subjectGroupDAO->show("id", $schedule["subject_group_id"]);
            array_push($schedules, new Schedule($schedule["id"], $space, $teacher, $subjectGroup, $schedule["start_hour"],
                $schedule["end_hour"], $schedule["day"]));
        }
        return $schedules;
    }
}