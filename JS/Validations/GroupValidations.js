function checkNameGroup(field) {
    const name = "nombre";
    const nameDiv = "name";
    if ((toret = checkEmpty(field, name)) === "" && (toret = withOutWhiteSpaces(field, name)) === ""
        && (toret = checkLength(field,'10', name)) === "" && (toret = checkText(field,'10', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('name-div', nameDiv, toret, field);
        return false;
    }
}

function checkNameEmptyGroup(field) {
    if (field.value.length > 0) {
        return checkCodeSubject(field);
    } else {
        return true;
    }
}

function checkCapacityGroup(field) {
    const name = "capacidad";
    const nameDiv = "capacity";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkInteger(field,0, 999, name)) === ""
        && (toret = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('capacity-div', nameDiv, toret, field);
        return false;
    }
}

function checkCapacityEmptyGroup(field) {
    if (field.value.length > 0) {
        return checkHoursSubject(field);
    } else {
        return true;
    }
}

function areGroupFieldsCorrect() {
    const form = $('#groupForm')[0];
    if(checkNameGroup(form.elements[0]) && checkCapacityGroup(form.elements[2])) {
        return true;
    } else {
        return false;
    }
}

function areGroupSearchFieldsCorrect() {
    const form = $('#groupSearchForm')[0];
    if(checkNameEmptyGroup(form.elements[0]) && checkCapacityEmptyGroup(form.elements[2])){
        return true;
    } else {
        return false;
    }
}



