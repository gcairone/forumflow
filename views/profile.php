<?php
require_once '../src/user_class.php';
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION["user"])) {
    // Utente non autenticato, reindirizza alla pagina di login
    header("Location: ../index.html");
    exit();
}

$userSession = $_SESSION["user"];

// Logout
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.html"); // Reindirizza alla pagina di login dopo il logout
    exit();
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $user = User::findByUsername($username);
    if(!($user instanceof User)) {
        $errorMessage = "Utente non trovato";
    }
}
else {
    $errorMessage = "Riprova più tardi";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>Profile Page</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div> <?php 
    if(!($user instanceof User)) echo "Utente non trovato"; 
    ?></div>
    <div>
        <?php if($user instanceof User) echo $user->toHTML(); ?>
    </div>
</body>
</html>


