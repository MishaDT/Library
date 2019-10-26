
function submitRegistration() {
    let form = document.registration;

    if (form.uname.value == "") {
        alert("Введите имя!");
        return false;
    } else if (form.uemail.value == "") {
        alert("Введите E-mail!");
        return false;
    } else if (form.upass.value == "") {
        alert("Введите пароль!");
        return false;
    }

}

function submitAuthorization() {
    let form = document.login;

    if (form.emailusername.value == "") {
        alert("Введите логин!");
        return false;
    } else if (form.upass.value == "") {
        alert("Введите пароль!");
        return false;
    }

}