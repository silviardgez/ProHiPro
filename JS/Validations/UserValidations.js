
function validateUserForm() {
    var x = document.forms["userForm"];
    console.log(x);
    email = document.getElementsByName("email")[0].value;
    if(!is_email(email)) {
        var invalidDiv = document.createElement("div");
        invalidDiv.style.backgroundColor = "#F08080";
        invalidDiv.style.borderRadius = ".3rem";
        invalidDiv.style.borderColor = "red";
        invalidDiv.style.marginTop = ".5rem";
        var newContent = document.createTextNode("Email inválido");
        invalidDiv.appendChild(newContent);
        $("#email").after(invalidDiv);
    }
    return false;
}

function is_email(email){
    var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailReg.test(email);
}
