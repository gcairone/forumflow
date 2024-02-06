<?php
require_once '../src/user_class.php';
session_start();

// Controlla se l'utente è loggato
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>User Profile</title>
    
</head>
<body>
    <?php include 'header.php'; ?>
    <div id='edit-container'>
        <?php echo $user->toHTML(); ?>
        <div id='edit-form-container'>
            <form action="edit.php" method="get">
                <button class='profile-button' type="submit">Modifica</button>
            </form>
            <form action="changepassword.php" method="get">
                <button class='profile-button' type="submit">Cambia Password</button>
            </form>
            <form id="deleteForm" action="delete_profile.php" method="post" onsubmit="return showConfirmationBanner()">
                <button class='profile-button' type="submit" name="delete_profile">Elimina Profilo</button>
            </form>
        </div>
    </div>

    <script>
        function showConfirmationBanner() {
            var confirmation = confirm("Sicuro di voler eliminare l'account?");
            return confirmation;
        }
    </script>


</body>
</html>
