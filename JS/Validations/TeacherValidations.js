function checkDedicationTeacher(field) {
    const name = "dedicación";
    const nameDiv = "dedication";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'30', name)) === ""
        && (toret = checkText(field,'30', name)) === "" && (toret = withOutWhiteSpaces(field, name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('dedication-div', nameDiv, toret, field);
        return false;
    }
}

function checkDedicationEmptyTeacher(field) {
    if (field.value.length > 0) {
        return checkDedicationTeacher(field);
    } else {
        return true;
    }
}

function areTeacherFieldsCorrect() {
    const form = $('#teacherForm')[0];
    if(checkDedicationTeacher(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areTeacherSearchFieldsCorrect() {
    const form = $('#teacherSearchForm')[0];
    if(checkDedicationEmptyTeacher(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}