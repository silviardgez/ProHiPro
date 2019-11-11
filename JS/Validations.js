function withOutWhiteSpaces(field) {
    if (/[\s]/.test(field.value)) {
        msgError('El atributo ' + field.name + ' no puede tener espacios');
        field.focus();
        return false;
    }
    return true; 
}

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

function checkAddUser() {

    var login; 
    var pwd;
    var pwd2;
    var dni; 
    var nameuser;
    var surnameuser;
    var email;
    var address
    var telf;

    login = document.forms['ADD'].elements[0];
    pwd = document.forms['ADD'].elements[1];
    pwd2 = document.forms['ADD'].elements[1];
    dni = document.forms['ADD'].elements[2];
    nameuser = document.forms['ADD'].elements[3];
    surnameuser = document.forms['ADD'].elements[4];
    email = document.forms['ADD'].elements[5];
    address = document.forms['ADD'].elements[6];
    telf = document.forms['ADD'].elements[7];

    if (!checkEmpty(login)) {
        return false;
    } else {
        if (!withOutWhiteSpaces(login)) {
            return false;
        } else {
            if (!checkLength(login, 9)) {
                return false;
            } else {
                if (!checkText(login, 9)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(pwd)) {
        return false;
    } else {
        if (!withOutWhiteSpaces(pwd)) {
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
    if (!checkEmpty(pwd2)) {
        return false;
    } else {
        if (!withOutWhiteSpaces(pwd2)) {
            return false;
        } else {
            if (!checkLength(pwd2, 20)) {
                return false;
            } else {
                if (!checkText(pwd2, 20)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(dni)) {
        return false;
    } else {
        if (!checkLength(dni, 9)) {
            return false;
        } else {
            if (!checkText(dni, 9)) {
                return false;
            } else {
                if (!checkDni(dni)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(nameuser)) {
        return false;
    } else {
        if (!checkLength(nameuser, 30)) {
            return false;
        } else {
            if (!checkText(nameuser, 30)) {
                return false;
            } else {
                if (!checkAlphabetical(nameuser, 30)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(surnameuser)) {
        return false;
    } else {
        if (!checkLength(surnameuser, 50)) {
            return false;
        } else {
            if (!checkText(surnameuser, 50)) {
                return false;
            } else {
                if (!checkAlphabetical(surnameuser, 50)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(email)) {
        return false;
    } else {
        if (!checkLength(email, 40)) {
            return false;
        } else {
            if (!checkText(email, 40)) {
                return false;
            } else {
                if (!checkEmail(email)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(address)) {
        return false;
    } else {
        if (!checkLength(address, 60)) {
            return false;
        } else {
            if (!checkText(address, 60)) {
                return false;
            }
        }
    }
    if (!checkEmpty(telf)) {
        return false;
    } else {
        if (!checkLength(telf, 11)) {
            return false;
        } else {
            if (!checkText(telf, 11)) {
                return false;
            } else {
                if (!checkTelf(telf)) {
                    return false;
                }
            }
        }
    }
    return true;
}

function checkEditUser() {

    var login;
    var pwd;
    var pwd2;
    var dni;
    var nameuser;
    var surnameuser;
    var email;
    var address
    var telf;

    login = document.forms['EDIT'].elements[0];
    pwd = document.forms['EDIT'].elements[1];
    pwd2 = document.forms['EDIT'].elements[2];
    dni = document.forms['EDIT'].elements[3];
    nameuser = document.forms['EDIT'].elements[4];
    surnameuser = document.forms['EDIT'].elements[5];
    email = document.forms['EDIT'].elements[6];
    address = document.forms['EDIT'].elements[7];
    telf = document.forms['EDIT'].elements[8];

    if (!checkEmpty(login)) {
        return false;
    } else {
        if (!withOutWhiteSpaces(login)) {
            return false;
        } else {
            if (!checkLength(login, 9)) {
                return false;
            } else {
                if (!checkText(login, 9)) {
                    return false;
                }
            }
        }
    }

    if (!checkEmpty(pwd)) {
        return false;
    } else {
        if (!withOutWhiteSpaces(pwd)) {
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

    if (!checkEmpty(pwd2)) {
        return false;
    } else {
        if (!withOutWhiteSpaces(pwd2)) {
            return false;
        } else {
            if (!checkLength(pwd2, 20)) {
                return false;
            } else {
                if (!checkText(pwd2, 20)) {
                    return false;
                }
            }
        }
    }

    if (!checkEmpty(dni)) {
        return false;
    } else {
        if (!checkLength(dni, 9)) {
            return false;
        } else {
            if (!checkText(dni, 9)) {
                return false;
            } else {
                if (!checkDni(dni)) {
                    return false;
                }
            }
        }
    }

    if (!checkEmpty(nameuser)) {
        return false;
    } else {
        if (!checkLength(nameuser, 30)) {
            return false;
        } else {
            if (!checkText(nameuser, 30)) {
                return false;
            } else {
                if (!checkAlphabetical(nameuser, 30)) {
                    return false;
                }
            }
        }
    }

    if (!checkEmpty(surnameuser)) {
        return false;
    } else {
        if (!checkLength(surnameuser, 50)) {
            return false;
        } else {
            if (!checkText(surnameuser, 50)) {
                return false;
            } else {
                if (!checkAlphabetical(surnameuser, 50)) {
                    return false;
                }
            }
        }
    }

    if (!checkEmpty(email)) {
        return false;
    } else {
        if (!checkLength(email, 40)) {
            return false;
        } else {
            if (!checkText(email, 40)) {
                return false;
            } else {
                if (!checkEmail(email)) {
                    return false;
                }
            }
        }
    }
    if (!checkEmpty(address)) {
        return false;
    } else {
        if (!checkLength(address, 60)) {
            return false;
        } else {
            if (!checkText(address, 60)) {
                return false;
            }
        }
    }

    if (!checkEmpty(telf)) {
        return false;
    } else {
        if (!checkLength(telf, 11)) {
            return false;
        } else {
            if (!checkText(telf, 11)) {
                return false;
            } else {
                if (!checkTelf(telf)) {
                    return false;
                }
            }
        }
    }
    return true;
}

function checkSearchUser() {

    var login;
    var pwd;
    var dni;
    var nameuser;
    var surnameuser;
    var email;
    var address
    var telf;

    login = document.forms['SEARCH'].elements[0];
    dni = document.forms['SEARCH'].elements[1];
    nameuser = document.forms['SEARCH'].elements[2];
    surnameuser = document.forms['SEARCH'].elements[3];
    email = document.forms['SEARCH'].elements[4];
    address = document.forms['SEARCH'].elements[5];
    telf = document.forms['SEARCH'].elements[6];

    if (!checkLength(login, 9)) {
        return false;
    } else {
        if (!checkText(login, 9)) {
            return false;
        }
    }

    if (!checkLength(pwd, 20)) {
        return false;
    } else {
        if (!checkText(pwd, 20)) {
            return false;
        }
    }



    if (!checkLength(dni, 9)) {
        return false;
    } else {
        if (!checkText(dni, 9)) {
            return false;
        } else {
            if (!checkDni(dni)) {
                return false;
            }
        }
    }

    if (!checkLength(nameuser, 30)) {
        return false;
    } else {
        if (!checkText(nameuser, 30)) {
            return false;
        } else {
            if (!checkAlphabetical(nameuser, 30)) {
                return false;
            }
        }
    }

    if (!checkLength(surnameuser, 50)) {
        return false;
    } else {
        if (!checkText(surnameuser, 50)) {
            return false;
        } else {
            if (!checkAlphabetical(surnameuser, 50)) {
                return false;
            }
        }
    }


    if (!checkLength(email, 40)) {
        return false;
    } else {
        if (!checkText(email, 40)) {
            return false;
        } else {
            if (!checkEmail(email)) {
                return false;
            }
        }
    }

    if (!checkLength(address, 60)) {
        return false;
    } else {
        if (!checkText(address, 60)) {
            return false;
        }
    }


    if (!checkLength(telf, 11)) {
        return false;
    } else {
        if (!checkText(telf, 11)) {
            return false;
        } else {
            if (!checkTelf(telf)) {
                return false;
            }
        }
    }

    return true;
}

function checkAddAcademicCourse() {

    var start_year;
    var end_year;

    start_year = document.forms['ADD'].elements[0];
    end_year = document.forms['ADD'].elements[1];
    //document.write('<div>Print this after the script tag</div>'+start_year.value+'--'+end_year.value);
    if(start_year.value>=end_year.value){
        msgError('El atributo ' + start_year.name + ' es mayor o igual que '+ end_year.name);
        start_year.focus();
        return false;
    }

    if(start_year.value!=(end_year.value-1)){
        msgError('No puede existir una diferencia de más de 1 año entre cursos.');
        start_year.focus();
        return false;
    }
    return true;

}

function checkEditAcademicCourse() {

    var start_year;
    var end_year;

    start_year = document.forms['EDIT'].elements[0];
    end_year = document.forms['EDIT'].elements[1];
    //document.write('<div>Print this after the script tag</div>'+start_year.value+'--'+end_year.value);
    if(start_year.value>=end_year.value){
        msgError('El atributo ' + start_year.name + ' es mayor o igual que '+ end_year.name);
        start_year.focus();
        return false;
    }

    if(start_year.value!=(end_year.value-1)){
        msgError('No puede existir una diferencia de más de 1 año entre cursos.');
        start_year.focus();
        return false;
    }
    return true;

}

function checkAddNameDescription() {
    var name;
    var description;

    name = document.forms['ADD'].elements[0];
    description = document.forms['ADD'].elements[1];

    if(!checkEmpty(name) || !checkLength(name, 60)){
        name.focus();
        return false;
    }
    if(!checkEmpty(description) || !checkLength(description, 100)){
        name.focus();
        return false;
    }
    return true;
}

function checkEditNameDescription() {
    var name;
    var description;

    name = document.forms['EDIT'].elements[0];
    description = document.forms['EDIT'].elements[1];

    if(!checkEmpty(name) || !checkLength(name, 60)){
        name.focus();
        return false;
    }
    if(!checkEmpty(description) || !checkLength(description, 100)){
        name.focus();
        return false;
    }
    return true;
}