<?php
require_once '../src/user_class.php';
require_once '../src/access_db.php';

session_start();

if (isset($_POST['delete_profile'])) {
    // Verifica se l'utente è autenticato
    if (!isset($_SESSION['user'])) {
        // L'utente non è autenticato, reindirizza alla pagina di login
        $errorMessage = "Utente non autenticato";
        header("Location: ../index.html");
    }
    $SessionUsername = $_SESSION['user']->Username;

    $errorMessage = "Pronto per eliminare" . $SessionUsername;

    
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);


    // Verifica la connessione
    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
        return null;
    }

    $sql = "DELETE FROM user WHERE Username = '$SessionUsername' ;";

    $success = $conn->query($sql);

    $errorMessage = "Eliminata correttamente";
    session_unset();
    session_destroy();
    header("Location: ../index.html"); 
    exit();
} else {
    $errorMessage = "Tentativo di accedere senza inviare il form";
    header("Location: ../index.html"); 
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
    <p><?php echo $errorMessage;  ?></p>
</body>
</html>
