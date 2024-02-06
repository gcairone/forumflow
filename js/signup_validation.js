

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('signupForm');

    form.addEventListener('submit', function (event) {
        // Esegui la validazione
        if (!validateEmail() || !validatePassword() || !validateUsername()) {
            // Se la validazione non è superata, impedisci l'invio del modulo
            event.preventDefault();
        }
        // Altrimenti, il modulo verrà inviato normalmente
    });


    // Aggiungi gli event listener agli input
    var usernameInput = document.getElementById('username')
    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');

    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', validatePassword);
    usernameInput.addEventListener('input', validateUsername);

    function validateUsername() {
        const regex = /^[a-zA-Z0-9_-]+$/;
        var usernameValue = usernameInput.value;
        if(!regex.test(usernameValue) && usernameValue !== "") {
            usernameInput.nextElementSibling.textContent = "Caratteri speciali non consentiti";
            return false;
        }
        else {
            usernameInput.nextElementSibling.textContent = "";
        }
        return true;
    }
    function validateEmail() {
        var emailValue = emailInput.value.trim();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailValue === "") {
            emailInput.nextElementSibling.textContent = "L'email è obbligatoria.";
            return false;
        } 
        else if (!emailPattern.test(emailValue)) {
            emailInput.nextElementSibling.textContent = "Inserisci un indirizzo email valido.";
            return false;
        } 
        else {
            emailInput.nextElementSibling.textContent = "";
            return true;
        }
    }

    function validatePassword() {
        var passwordValue = passwordInput.value.trim();

        if (passwordValue === "") {
            passwordInput.nextElementSibling.textContent = "La password è obbligatoria.";
            return false;
        } 
        else if (passwordValue.length < 8) {
            passwordInput.nextElementSibling.textContent = "La password deve contenere almeno 8 caratteri.";
            return false;
        } 
        else {
            passwordInput.nextElementSibling.textContent = "";
            return true;
        }
    }
});

