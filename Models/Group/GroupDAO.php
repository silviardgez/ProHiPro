<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once 'SubjectGroup.php';

class GroupDAO
{
    private $defaultDAO;
    private $subjectDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->subjectDAO = new SubjectDAO();
    }

    function showAll()
    {
        $groups_db = $this->defaultDAO->showAll("subject_group");
        return $this->getGroupsFromDB($groups_db);
    }

    function add($group)
    {
        $this->defaultDAO->insert($group, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("subject_group", $key, $value);
    }

    function show($key, $value)
    {
        $group = $this->defaultDAO->show("subject_group", $key, $value);
        $subject = $this->subjectDAO->show("id", $group["subject_id"]);
        return new SubjectGroup($group["id"], $subject, $group["name"], $group["capacity"]);

    }

    function edit($group)
    {
        $this->defaultDAO->edit($group, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("subject_group");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $groupsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage,
            new SubjectGroup(), $stringToSearch);
        return $this->getGroupsFromDB($groupsDB);
    }

    function countTotalGroups($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new SubjectGroup(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("subject_group", $value);
    }

    private function getGroupsFromDB($groups_db)
    {
        $groups = array();
        foreach ($groups_db as $group) {
            $subject = $this->subjectDAO->show("id", $group["subject_id"]);
            array_push($groups, new SubjectGroup($group["id"], $subject, $group["name"], $group["capacity"]));
        }
        return $groups;
    }
}
