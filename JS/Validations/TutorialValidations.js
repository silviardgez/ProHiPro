function checkTotalHoursTutorial(field) {
    const name = "total_horas";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkInteger(field,0, 10, name)) === ""
        && (toret = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('total-hours-div', name, toret, field);
        return false;
    }
}

function checkTotalHoursEmptyTutorial(field) {
    if (field.value.length > 0) {
        return checkHoursSubject(field);
    } else {
        return true;
    }
}

function areTutorialFieldsCorrect() {
    const form = $('#tutorialForm')[0];
    if(checkTotalHoursTutorial(form.elements[2])) {
        return true;
    } else {
        return false;
    }
}

function areTutorialSearchFieldsCorrect() {
    const form = $('#subjectSearchForm')[0];
    if(checkCodeEmptySubject(form.elements[0]) && checkContentEmptySubject(form.elements[1]) &&
        checkTypeEmptySubject(form.elements[2]) && checkAreaEmptySubject(form.elements[4]) &&
        checkCourseEmptySubject(form.elements[5]) && checkQuarterEmptySubject(form.elements[6]) &&
        checkCreditsEmptySubject(form.elements[7]) && checkNewRegistrationEmptySubject(form.elements[8]) &&
        checkRepeatersEmptySubject(form.elements[9]) && checkEffectiveStudentsEmptySubject(form.elements[10]) &&
        checkEnrolledHoursEmptySubject(form.elements[11]) && checkTaughtHoursEmptySubject(form.elements[12]) &&
        checkHoursEmptySubject(form.elements[13]) && checkStudentsEmptySubject(form.elements[14])
    ) {
        return true;
    } else {
        return false;
    }
}



