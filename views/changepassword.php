<?php
require_once '../src/user_class.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.html"); // Reindirizza alla pagina di login se l'utente non è loggato
    exit();
}

$user = $_SESSION['user'];

// Logout
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.html"); // Reindirizza alla pagina di login dopo il logout
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    if($user->saveToDatabase()) {
        // Reindirizza alla pagina del profilo dopo la modifica
        header("Location: personal_profile.php");
        exit();
    }
    else {
        $messageError = "Errore, riprova più tardi";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <script src="../js/change_password_validation.js"></script>

</head>
<body>
    <?php include 'header.php'; ?>
    <div class='container' id="changepassword-container">
        <div class='section-title'>Cambia Password</div>

        <form method="post" action="changepassword.php" class='grid-form'>
            <label for="password">Nuova Password:   </label>
            <input type="text" id="password" name="password" required>
            <label for="confirm-password">Conferma Password:</label>
            <input type="text" id="confirm-password" name="confirm-password" required>
            <br>
            <button type="submit">Salva</button>

        </form>
        <p class="error-message" id="errorPasswordConfirm"></p>
        <p class="error-message"><?php if(isset($messageError)) echo $messageError; ?></p>
    </div>
</body>
</html>
