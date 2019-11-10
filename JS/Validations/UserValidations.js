function checkDniUser(field) {
    const name = "dni";
    if ((toret = checkEmpty(field, name)) === "" && (toret = withOutWhiteSpaces(field, name)) === ""
        && (toret = checkLength(field,'9', name)) === "" && (toret = checkText(field,'9', name)) === "" &&
        (toret = checkDni(field, name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('dni-div', name, toret, field);
        return false;
    }
}

function checkDniEmptyUser(field) {
    if (field.value.length > 0) {
        return checkDniUser(field);
    } else {
        return true;
    }
}

function checkLoginUser(field) {
    const name = "login";
    if ((toret = checkEmpty(field, name)) === "" && (toret = withOutWhiteSpaces(field, name)) === ""
        && (toret = checkLength(field,'9', name)) === "" && (toret = checkText(field,'9', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('login-div', name, toret, field);
        return false;
    }
}

function checkLoginEmptyUser(field) {
    if (field.value.length > 0) {
        return checkLoginUser(field);
    } else {
        return true;
    }
}

function checkPasswordUser(field) {
    const name = "contraseña";
    if ((toret = checkEmpty(field, name)) === "" && (toret = withOutWhiteSpaces(field, name)) === ""
        && (toret = checkLength(field,'20', name)) === "" && (toret = checkText(field,'20', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('password-div', name, toret, field);
        return false;
    }
}

function checkPasswordEmptyUser(field) {
    if (field.value.length > 0) {
        return checkPasswordUser(field);
    } else {
        return true;
    }
}

function checkConfirmPasswordUser(field) {
    const name = "confirmación de contraseña";
    nameDiv = "confirmation";
    password = $('#password1').val();
    if ((toret = checkEmpty(field, name)) === "" && (toret = withOutWhiteSpaces(field, name)) === ""
        && (toret = checkLength(field,'20', name)) === "" && (toret = checkText(field,'20', name)) === "") {
        if(password !== field.value) {
            showMessage('confirm-password-div', nameDiv, "Las contraseñas no coinciden.", field);
        } else {
            deleteMessage(nameDiv);
            return true;
        }
    } else {
        showMessage('confirm-password-div', nameDiv, toret, field);
        return false;
    }
}

function checkConfirmPasswordEmptyUser(field) {
    if (field.value.length > 0) {
        return checkConfirmPasswordEmptyUser(field);
    } else {
        return true;
    }
}

function checkNameUser(field) {
    const name = "nombre";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'30', name)) === ""
        && (toret = checkText(field,'30', name)) === "" && (toret = checkAlphabetical(field,'30', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, toret, field);
        return false;
    }
}

function checkNameEmptyUser(field) {
    if (field.value.length > 0) {
        return checkNameUser(field);
    } else {
        return true;
    }
}

function checkSurnameUser(field) {
    const name = "apellido";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'50', name)) === ""
        && (toret = checkText(field,'50', name)) === "" && (toret = checkAlphabetical(field,'50', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('surname-div', name, toret, field);
        return false;
    }
}

function checkSurnameEmptyUser(field) {
    if (field.value.length > 0) {
        return checkSurnameUser(field);
    } else {
        return true;
    }
}

function checkEmailUser(field) {
    const name = "email";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'40', name)) === ""
        && (toret = checkText(field,'40', name)) === "" && (toret = checkEmail(field, name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('email-div', name, toret, field);
        return false;
    }
}

function checkEmailEmptyUser(field) {
    if (field.value.length > 0) {
        return checkEmailUser(field);
    } else {
        return true;
    }
}

function checkAddressUser(field) {
    const name = "dirección";
    nameDiv = "direction";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'60', name)) === ""
        && (toret = checkText(field,'60', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('address-div', nameDiv, toret, field);
        return false;
    }
}

function checkAddressEmptyUser(field) {
    if (field.value.length > 0) {
        return checkAddressUser(field);
    } else {
        return true;
    }
}

function checkTelephoneUser(field) {
    const name = "teléfono";
    nameDiv = "telephone";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'11', name)) === ""
        && (toret = checkTelf(field, name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('telephone-div', nameDiv, toret, field);
        return false;
    }
}

function checkTelephoneEmptyUser(field) {
    if (field.value.length > 0) {
        return checkTelephoneUser(field);
    } else {
        return true;
    }
}

function areUserFieldsCorrect() {
    const form = $('#userForm')[0];
    if(checkLoginUser(form.elements[0]) && checkPasswordUser(form.elements[1]) &&
        checkConfirmPasswordUser(form.elements[2]) && checkDniUser(form.elements[3]) &&
        checkNameUser(form.elements[4]) && checkSurnameUser(form.elements[5]) &&
        checkEmailUser(form.elements[6]) && checkAddressUser(form.elements[7]) &&
        checkTelephoneUser(form.elements[8])) {
        return true;
    } else {
        return false;
    }
}

function areUserEditFieldsCorrect() {
    const form = $('#userEditForm')[0];
    if(checkLoginUser(form.elements[0]) && checkPasswordEmptyUser(form.elements[1]) &&
        checkConfirmPasswordEmptyUser(form.elements[2]) && checkDniUser(form.elements[3]) &&
        checkNameUser(form.elements[4]) && checkSurnameUser(form.elements[5]) &&
        checkEmailUser(form.elements[6]) && checkAddressUser(form.elements[7]) &&
        checkTelephoneUser(form.elements[8])) {
        return true;
    } else {
        return false;
    }
}

function areUserSearchFieldsCorrect() {
    const form = $('#userSearchForm')[0];
    if(checkLoginEmptyUser(form.elements[0]) && checkDniEmptyUser(form.elements[1]) &&
        checkNameEmptyUser(form.elements[2]) && checkSurnameEmptyUser(form.elements[3]) &&
        checkEmailEmptyUser(form.elements[4]) && checkAddressEmptyUser(form.elements[5]) &&
        checkTelephoneEmptyUser(form.elements[6])) {
        return true;
    } else {
        return false;
    }
}

function areLoginFieldsCorrect() {
    const form = $('#loginForm')[0];
    if(checkLoginUser(form.elements[0]) && checkPasswordUser(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}