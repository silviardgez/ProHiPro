<?php
include_once "../Models/Tutorial/TutorialDAO.php";
include_once "../Models/Tutorial/Tutorial.php";

function IsTutorialOwner()
{
    $toret = array();
    $tutorialDAO = new TutorialDAO();
    try {
        $tutorials = $tutorialDAO->showAll();
        foreach ($tutorials as $tutorial) {
            if ($tutorial->getTeacher()->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $tutorial);
            }
        }
        if (empty($toret)) {
            return false;
        } else {
            return $toret;
        }
    } catch (DAOException $e) {
        return false;
    }
}