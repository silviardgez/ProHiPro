function withOutWhiteSpaces(field, name) {
    if (/[\s]/.test(field.value)) {
        return 'El atributo ' + name + ' no puede tener espacios en blanco.';
    }
    return ""; 
}

function checkEmpty(field, name) {

    if (field.value == null || field.value.length == 0 || /^\s+$/.test(field.value)) {
        return "El atributo " + name + " no puede estar vacío.";
    }
    return "";
}

function checkLength(field, size, name) {
    if (field.value.length > size) {
        return 'El atributo ' + name + ' puede tener una longitud máxima de %' + size + '%.';
    }
    return "";
}

function checkText(field, size, name) {
    var i;
    for (i = 0; i < size; i++) {
        if (/[^!"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~ñáéíóúÑÁÉÍÓÚüÜ ]/.test(field.value.charAt(i))) {
            return 'El atributo ' + name + ' contiene algún carácter no válido: %' + field.value.charAt(i) + '%.';
        }
    }
    return "";
}

function checkAlphabetical(field, size, name) {
    var i;

    for (i = 0; i < size; i++) {
        if (/[^A-Za-zñáéíóúÑÁÉÍÓÚüÜ -]/.test(field.value.charAt(i))) {
            return 'El atributo ' + name + ' solo admite carácteres alfabéticos.';
        }
    }
    return "";
}

function checkInteger(field, minValue, maxValue, name) {
    if (!/^([0-9])*$/.test(field.value)) {
        return 'El atributo ' + name + ' tiene que ser un dígito.';
    } else {
        if (field.value > maxValue) {
            return 'El atributo ' + name + ' no puede ser mayor que %' + maxValue + '%.';
        } else {
            if (field.value < minValue) {
                return 'El atributo ' + name + ' no puede ser menor que %' + minValue + '%.';
            }
        }
    }
    return "";
}

function checkDni(field, name) {
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
            return 'El atributo ' + name + ' tiene un formato erróneo, la letra del NIF no se corresponde.';
        } else {
            return "";
        }
    } else {
        return 'El atributo ' + name + ' tiene un formato erróneo.';
    }
}

function checkTelf(field, name) {
    if (!/^(34)?[6|7|9][0-9]{8}$/.test(field.value)) {
        return 'El atributo ' + name + ' tiene un formato erróneo.';
    }
    return "";
}

function checkEmail(field, name) {
    if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(field.value)) {
        return 'El atributo ' + name + ' tiene un formato erróneo.';
    }
    return "";
}

function showMessage(parentNode, name, message, field) {
    parentNode = '#' + parentNode;
    node = '#message-error-' + name;
    if($(node).length)
    {
        $(node).html("<p data-translate='" + message + "'></p>");
        translatePage();
    } else {
        $('<div id="message-error-' + name + '" class="message-error"><p data-translate="' + message + '"></p></div>').appendTo(parentNode);
        translatePage();
    }
}

function deleteMessage(node) {
    node = '#message-error-' + node;
    if($(node).length) {
        $(node).remove();
    }
}
