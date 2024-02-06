
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('signupForm');
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirm-password');

    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);
    form.addEventListener('submit', function (event) {
        if (!validatePassword()) {
            event.preventDefault();
        }
    });

});

function validatePassword() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    var errorMessage = document.getElementById('errorPasswordConfirm');

    if (password.length < 8) {
        errorMessage.textContent = "Almeno 8 caratteri";
        return false;
    }

    if (password !== confirmPassword) {
        errorMessage.textContent = "La conferma non corrisponde";
        return false;
    }
    errorMessage.textContent = "";
    return true;
}
