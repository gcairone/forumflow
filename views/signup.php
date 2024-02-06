<?php
require_once '../src/user_class.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $additionalInfo = $_POST['additional_info'];
    
    $newUser = new User($username, $email, $password, $additionalInfo, null, null);
    $validationResult = $newUser->validation();
    
    if ($validationResult === true) {
        
        if ($newUser->saveToDatabase()) {
            $_SESSION["user"] = $newUser;
            header('Location: main.php');
            exit();
        } else {
            $errorMessage = "Si è verificato un errore durante la registrazione. Riprova più tardi.";
        }
        
    } 
    else {
        $errorMessage = $validationResult;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/signup_validation.js"></script>
</head>
<body>
    <div class="background">
        <div class="container" id="signup-box">
            <h1>ForumFlow - Sign Up</h1>
            <br>

            <form method="post" action="signup.php" id='signupForm' class='grid-form'>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" maxlength="20" required>
                <p class="error-message" id="errorUsername"></p>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" maxlength="40" required>
                <p class="error-message" id="errorEmail"></p>
            
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <p class="error-message" id="errorPassword"></p>

                <label for="additional_info">Informazioni aggiuntive:</label>
                <textarea  name="additional_info" id="additional_info" maxlength="256"></textarea>
                <br>

                <button type="submit" class="btn">Sign Up</button>
                <?php
                // Mostra messaggi di errore, se presenti
                if (isset($errorMessage)) {
                    echo "<div class='error-message'> $errorMessage </div>"; // anche dovuti alla validazione lato server
                }
                ?> 

            </form>
        </div>

    </div>
    
</body>
</html>
