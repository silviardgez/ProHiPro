<?php

class DegreeEditView
{
    private $centers;
    private $degree;
    private $users;

    function __construct($degreeData, $centers, $users)
    {
        $this->centers = $centers;
        $this->degree = $degreeData;
        $this->users = $users;
        $this->render();
    }

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
                <h1 class="h2" data-translate="Editar titulación '%<?php echo $this->degree->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../Controllers/DegreeController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="degreeForm"
                  action='../Controllers/DegreeController.php?action=edit&id=<?php echo $this->degree->getId() ?>'
                  method='POST' onsubmit="areDegreeFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->degree->getName() ?>" required maxlength="30"
                           oninput="checkNameDegree(this)">
                </div>
                <div class="form-group">
                    <label for="center_id" data-translate="Centro"></label>
                    <select class="form-control" id="center_id" name="center_id" required>
                        <?php foreach ($this->centers as $center): ?>
                            <option value="<?php echo $center->getId() ?>"
                                <?php if ($center->getId() == $this->degree->getCenter()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $center->getName(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"
                                <?php if ($user->getId() == $this->degree->getUser()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $user->getName() . " " . $user->getSurname(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="capacity-div" class="form-group">
                    <label for="name" data-translate="Capacidad"></label>
                    <input type="number" min="0" max="999" class="form-control" id="capacity" name="capacity"
                           data-translate="Introducir capacidad"
                           value="<?php echo $this->degree->getCapacity() ?>" required maxlength="3"
                           oninput="checkCapacityDegree(this)">
                </div>
                <div id="credits-div" class="form-group">
                    <label for="name" data-translate="Créditos"></label>
                    <input type="number" min="0" max="999" class="form-control" id="credits" name="credits"
                           data-translate="Introducir créditos"
                           value="<?php echo $this->degree->getCredits() ?>" required maxlength="3"
                           oninput="checkCapacityDegree(this)">
                </div>
                <div id="description-div" class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->degree->getDescription() ?>" max-length="100" required
                           oninput="checkDescriptionDegree(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>
