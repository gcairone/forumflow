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
    header("Location: ../index.html"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->AdditionalInfo = $_POST['additional_info'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Verifica il tipo di file
        $allowedTypes = ['image/jpeg', 'image/png'];
        
        if (!in_array($_FILES['file']['type'], $allowedTypes)) {
            // echo 'Errore: Il tipo di file non è supportato.';
            $messageError = "Errore: Il tipo di file non è supportato";
            exit;
        }

        $maxFileSize = 1024 * 1024; // 1 MB in byte
        if ($_FILES['file']['size'] > $maxFileSize) {
            $messageError = "Errore: La dimensione del file supera il limite consentito";
            exit;
        }

        $uploadDir = '../img/profiles/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        //carica l'immagine
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

        //carica nel database il path
        $user->ImgPath = $uploadFile;
        //debugging
        $messageError = $user->ImgPath;
    }

    if($user->saveToDatabase()) {
        header("Location: personal_profile.php");
        exit();
    }
    else {
        $messageError = "Errore nel salvataggio, provare più tardi";
    }
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
    <title>Modifica Profilo</title>
    
</head>
<body>
    <?php include 'header.php'; ?>
    <div class='container' id="edit-profile-container">
        <div class='section-title'>Modifica Profilo</div>

        <form method="post" action="edit.php" enctype="multipart/form-data" class="edit-profile-form">
            <label for="additional_info">Nuove Informazioni Aggiuntive:</label>
            <textarea id="additional_info" name="additional_info" maxlength="250"><?php echo $user->AdditionalInfo; ?></textarea>

            <label for="file">Scegli un'immagine di profilo:</label>
            <input type="file" name="file" id="file" accept="image/*">

            <button type="submit">Salva Modifiche</button>
        </form>

        <p class="error-message"><?php if(isset($messageError)) echo $messageError; ?></p>
    </div>

</body>
</html>
