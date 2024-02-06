<?php
require_once '../src/question_class.php';
require_once '../src/user_class.php';
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION["user"]) || !isset($_GET['id'])) {
    // Utente non autenticato oppure richiesta get non consistente
    header("Location: ../index.html");
    exit();
}
$userSession = $_SESSION['user'];
// Get the username from the GET request
$question_id = $_GET['id'];
// Find the user by username
$question = Question::findById($question_id);

// Logout
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.html"); // Reindirizza alla pagina di login dopo il logout
    exit();
}

if($question !== null) {
    if(isset($_POST['postAnswer'])) {
        // CRea l'istanza della classe, id e insertDatetime sono messi dal database, quindi null
        $answer_to_send = new Answer(null, $question_id, $_SESSION['user']->Username, htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8'), null);
        if ($answer_to_send->saveToDatabase()) {
            // La risposta è stato registrato con successo
            $errorMessage = "Inviata!";
        } else {
            $errorMessage = "Si è verificato un errore durante la registrazione. Riprova più tardi.";
        }
    }
}
else {
    $errorMessage = "Question not found";
}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/answer.css">
    <link rel="stylesheet" href="../css/question.css">
    <title> Question Page</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div>  <?php if(isset($errorMessage)) echo $errorMessage; ?> </div>
    <div>
        <?php echo $question->toHTML_inQuestion(); ?> 
    </div>

    <div class='container' id='post-answer-box'>
        <div class='section-title'>Post an answer! </div>
        <form class='post-answer-form' method="post" action="question.php?id=<?php echo $question_id; ?>">
            <textarea name="body" maxlength="1000" required></textarea><br>
            <button type="submit" name="postAnswer">Post</button>
        </form>
    </div>

    <div>
        <?php $question->getAnswersHTML(); ?> 
    </div>
</body>
</html>