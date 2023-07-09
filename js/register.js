function ToggleOrganizerInputs() {
    document.register.organizationName.disabled = !document.register.asOrganizer.checked;
    document.register.organizationAddress.disabled = !document.register.asOrganizer.checked;
    document.register.organizationNumber.disabled = !document.register.asOrganizer.checked;
    
    document.register.organizationName.required=document.register.asOrganizer.checked;
    document.register.organizationAddress.required = document.register.asOrganizer.checked;
    document.register.organizationNumber.required = document.register.asOrganizer.checked;
}

function validateRegisterParams() {

    const pwRegExp = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z][A-Za-z\d@$!%*#?&]{7,15}$/;
    if (document.register.firstName.value.length>50) {
        var message = "Ime mora imati najviše 50 karaktera";
    }
    else if (document.register.lastName.value.length>50) {
        var message = "Prezime mora imati najviše 50 karaktera";
    }
    else if (document.register.username.value.length>50) {
        var message = "Korisničko ime mora imati najviše 50 karaktera";
    }
    else if (document.register.password.value.length>16) {
        var message = "Lozinka mora imati najviše 16 karaktera";
        document.register.password.value="";
        document.register.repeatPassword.value="";
    }
    else if (document.register.phoneNumber.value.length>20) {
        var message = "Broj telefona mora imati najviše 20 karaktera i sadržati samo brojeve.";
    }
    else if (document.register.email.value.length>100) {
        var message = "E-mail adresa mora imati najviše 100 karaktera";
    }
    else if (!pwRegExp.test(document.register.password.value)) {
        var message = "Lozinka mora počinjati slovom, i mora imati 8-16 karaktera od kojih najmanje jedno veliko slovo, jednu cifru i jedan specijalni karakter";
        document.register.password.value="";
        document.register.repeatPassword.value="";
    }
    else if (document.register.password.value!=document.register.repeatPassword.value) {
        var message = "Lozinke se ne poklapaju";
        document.register.password.value="";
        document.register.repeatPassword.value="";
    }

    if (document.register.asOrganizer.checked) {
        if (document.register.organizationName.value>50) {
            var message = "Ime organizacije mora imati najviše 50 karaktera";
        }
        else if (document.register.organizationAddress.value.length>200) {
            var message = "Adresa organizacije mora imati najviše 200 karaktera";
        }
        else if (document.register.organizationNumber.value.length>50) {
            var message = "Matični broj organizacije mora imati najviše 50 karaktera";
        }
    }

    if (message) {
        alert(message);
        return false;
    }
    else {
        return true;
    }
}

function validateUpdateParams() {

    if (document.register.firstName.value.length>50) {
        var message = "Ime mora imati najviše 50 karaktera";
    }
    else if (document.register.lastName.value.length>50) {
        var message = "Prezime mora imati najviše 50 karaktera";
    }
    else if (document.register.phoneNumber.value.length>20) {
        var message = "Broj telefona mora imati najviše 20 karaktera i sadržati samo brojeve.";
    }

    if (message) {
        alert(message);
        return false;
    }
    else {
        return true;
    }
}

function updatePassword() {

    const pwRegExp = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z][A-Za-z\d@$!%*#?&]{7,15}$/;
    if (document.changePassword.newPassword.value!=document.changePassword.newPasswordRepeat.value) {
        var message = "Lozinke se ne poklapaju";
        document.changePassword.oldPassword.value="";
        document.changePassword.newPassword.value="";
        document.changePassword.newPasswordRepeat.value="";
    }
    else if (!pwRegExp.test(document.changePassword.newPassword.value)) {
        var message = "Lozinka mora počinjati slovom, i mora imati 8-16 karaktera od kojih najmanje jedno veliko slovo, jednu cifru i jedan specijalni karakter";
        document.changePassword.oldPassword.value="";
        document.changePassword.newPassword.value="";
        document.changePassword.newPasswordRepeat.value="";
    }

    if (message) {
        alert(message);
        return false;
    }
    else {
        return true;
    }

}