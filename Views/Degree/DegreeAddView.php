<?php

class DegreeAddView
{
    private $centers;
    private $users;

    function __construct($centersData, $users)
    {
        $this->centers = $centersData;
        $this->users = $users;
        $this->render();
    }

    private $description;
    private $credits;

    function render()
    {
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css"/>
            <link rel="stylesheet" href="../CSS/forms.css"/>
            <script src="../JS/Validations/DegreeValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-degree pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Insertar titulación"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DegreeController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="degreeForm" action='../Controllers/DegreeController.php?action=add' method='POST'
                  onsubmit="areDegreeFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           required maxlength="30" oninput="checkNameDegree(this)">
                </div>
                <div class="form-group">
                    <label for="center_id" data-translate="Centro"></label>
                    <select class="form-control" id="center_id" name="center_id" required>
                        <?php foreach ($this->centers as $center): ?>
                            <option value="<?php echo $center->getId() ?>"><?php echo $center->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getLogin() ?>"><?php echo $user->getName() . " " . $user->getSurname() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="capacity-div" class="form-group">
                    <label for="capacity" data-translate="Capacidad"></label>
                    <input type="number" min="0" max="999" class="form-control" id="capacity" name="capacity"
                           data-translate="Capacidad" required maxlength="3" oninput="checkCapacityDegree(this)">
                </div>
                <div id="credits-div" class="form-group">
                    <label for="credits" data-translate="Créditos"></label>
                    <input type="number" min="0" max="999" class="form-control" id="credits" name="credits"
                           data-translate="Créditos" required maxlength="3" oninput="checkCapacityDegree(this)">
                </div>
                <div id="description-div" class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           data-translate="Introducir descripción"
                           maxlength="50" required oninput="checkDescriptionAction(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
