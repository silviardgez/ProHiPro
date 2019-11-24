function checkHoursSubjectTeacher(field) {
    const name = "horas";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkInteger(field,0, 24, name)) === ""
        && (toret = checkLength(field,'2', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('hours-div', name, toret, field);
        return false;
    }
}

function areSubjectTeacherFieldsCorrect() {
    const form = $('#subjectTeacherForm')[0];
    if(checkHoursSubjectTeacher(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}