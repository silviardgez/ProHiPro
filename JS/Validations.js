
function checkEmpty(field) {

    if (field.value == null || field.value.length == 0 || /^\s+$/.test(field.value)) {
        msgError('El atributo ' + field.name + ' no puede ser vacío');
        field.focus();
        return false;
    }
    return true;
}

function checkLength(field, size) {
    if (field.value.length > size) {
        msgError('El atributo ' + field.name + ' puede tener una longitud máxima de ' + size);
        field.focus();
        return false;
    }
    return true;
}

function checkText(field, size) {
    var i;
    for (i = 0; i < size; i++) {
        if (/[^!"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~ñáéíóúÑÁÉÍÓÚüÜ ]/.test(field.value.charAt(i))) {
            msgError('El atributo ' + field.name + ' contiene algún carácter no válido: ' + field.value.charAt(i))
            field.focus();
            return false;
        }
    }
    return true;
}

function checkAlphabetical(field, size) {
    var i;

    for (i = 0; i < size; i++) {
        if (/[^A-Za-zñáéíóúÑÁÉÍÓÚüÜ -]/.test(field.value.charAt(i))) {
            msgError('El atributo ' + field.name + ' solo admite carácteres alfabéticos');
            field.focus();
            return false;
        }
    }
    return true;
}

function checkInteger(field, minValue, maxValue) {
    if (!/^([0-9])*$/.test(field.value)) {
        msgError('El atributo ' + field.name + ' tiene que ser un dígito');
        field.focus();
        return false;
    } else {
        if (field.value > maxValue) {
            msgError('El atributo ' + field.name + ' no puede ser mayor que' + maxValue);
            field.focus();
            return false;
        } else {
            if (field.value < minValue) {
                msgError('El atributo ' + field.name + ' no puede ser menor que' + minValue);
                field.focus();
                return false;
            }
        }
    }
    return true;
}

function checkDni(field) {
    var num;
    var letr;
    var letter;
    var regex_dni;
    letter = 'TRWAGMYFPDXBNJZSQVHLCKET';
    regex_dni = /^\d{8}[a-zA-Z]$/;

    if (regex_dni.test(field.value)) {
        num = field.value.substr(0, 8);
        letr = field.value.substr(8, 1);
        num = num % 23;
        letter = letter.substring(num, num + 1);
        if (letter != letr.toUpperCase()) {
            msgError('El atributo ' + field.name + ' tiene un formato erróneo, la letra del NIF no se corresponde')
            field.focus();
            return false;
        } else {
            return true;
        }
    } else {
        msgError('El atributo ' + field.name + ' tiene un formato erróneo');
        field.focus();
        return false;
    }
}

function checkTelf(field) {
    if (!/^(34)?[6|7|9][0-9]{8}$/.test(field.value)) {
        msgError('El atributo ' + field.name + ' tiene un formato erróneo');
        field.focus();
        return false;
    }
    return true;
}

function checkEmail(field) {
    if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(field.value)) {
        msgError('El atributo ' + field.name + ' tiene un formato erróneo');        field.focus();
        return false;
    }
    return true;
}

function abrirVentana() {
    document.getElementById("capaFondo1").style.visibility = "visible";
    document.getElementById("capaVentana").style.visibility = "visible";
    document.formError.bAceptar.focus();
}

function cerrarVentana() {
    document.getElementById("capaFondo1").style.visibility = "hidden";
    document.getElementById("capaVentana").style.visibility = "hidden";
    document.formError.bAceptar.blur();
}

function msgError(msg) {

    var miDiv = document.getElementById("miDiv");
    var html = "";

    miDiv.innerHTML = "";
    html = msg;
    miDiv.innerHTML = html;
    abrirVentana();
    return true;
}



function checkLogin() {

    var login;
    var pwd;

    login = document.forms['formLogin'].elements[0];
    pwd = document.forms['formLogin'].elements[1];

    if (!checkEmpty(login)) {
        return false;
    } else {
        if (!checkLength(login, 9)) {
            return false;
        } else {
            if (!checkText(login, 9)) {
                return false;
            }
        }
        if (!checkEmpty(pwd)) {
            return false;
        } else {
            if (!checkLength(pwd, 20)) {
                return false;
            } else {
                if (!checkText(pwd, 20)) {
                    return false;
                }
            }
        }

    }

    return true;
}
