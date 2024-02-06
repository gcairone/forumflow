<?php
require_once '../src/user_class.php';
require_once '../src/question_class.php';
require_once '../src/getQuestionMain.php';
require_once '../src/access_db.php';
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION["user"])) {
    // Utente non autenticato, reindirizza alla pagina di login
    header("Location: ../index.html");
    exit();
}

// Recupera l'utente dalla sessione
$userSession = $_SESSION["user"];

// Connessione per ottenere le cateforie
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Ottieni le categorie
$sql = "
SELECT Name
FROM category;";

$result = $conn->query($sql);



// Logout
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.html"); // Reindirizza alla pagina di login dopo il logout
    exit();
}

// Posta una domanda
if(isset($_POST['postQuestion'])) {
    // CRea l'istanza della classe, id e insertDatetime sono messi dal database, quindi null
    $question_to_send = new Question(null, $userSession->Username, htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8'), $_POST['cat'], null);
    //salva nel database
    $validationResult = $question_to_send->validation();
    if($validationResult === true) {
        if ($question_to_send->saveToDatabase()) {
            // L'utente è stato registrato con successo
            $errorMessage = "Inviata!";
        } else {
            // Si è verificato un errore durante il salvataggio nel database
            $errorMessage = "Si è verificato un errore durante la registrazione. Riprova più tardi.";
        }
    }
    else {
        $errorMessage = $validationResult;
    }
}

$per_page = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $per_page;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/question.css">
    <link rel="stylesheet" href="../css/mainpage.css">
    <title>Document</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div> <?php if(isset($errorMessage)) echo $errorMessage; ?> </div>  
    <div class='main-container'>
        <div class='sidebar-left'>
            <div class='container' id='search-box'>
                <form action="main.php" method="get" class="category-form">
                    <label >Seleziona categorie:</label>
                    <div class="category-checkboxes">
                        <?php 
                            // Popola il menu a tendina con le categorie
                            $result->data_seek(0);
                            echo "<br>";
                            while ($row = $result->fetch_assoc()) {
                                $cat_name = $row['Name'];
                                echo "<input type='checkbox' id=\"$cat_name\" name=\"$cat_name\">";
                                echo "<label for=\"$cat_name\">$cat_name</label> <br>";
                            }
                        ?>
                    </div>
                    <button type="submit">Ricerca</button>
                </form>
            </div>
        </div>
        
        <div class='main-content'>
            <div class="container" id='evidence-questions-box'>
                <p class='section-title'> In Evidenza  </p>
                <?php getQuestions($start_from, $per_page) ?>
            </div>
        </div>

        <div class='sidebar-right'>
            <div class="container" id='post-question-box'>
                <div class="section-title">Pubblica una domanda! </div>
                <form method="post" action="main.php" class="post-question-form">
                    <select name="cat" id="cat" required>
                        <option value="" disabled selected>Seleziona</option>
                        <?php 
                            $result->data_seek(0);
                            // Popola il menu a tendina con le categorie
                            while ($row = $result->fetch_assoc()) {
                                $cat_name = $row['Name'];
                                echo "<option value=\"$cat_name\">$cat_name</option>";
                            }
                        ?>
                    </select>
                    <textarea name="body" maxlength="255" required></textarea>
                    <br>
                    <button type="submit" name="postQuestion">Post</button>
                </form>
            </div>

            <div class="container" id='user-questions-box'>
                <p class='section-title'> Le tue ultime domande </p>
                <?php getUserQuestions() ?>
            </div>
        </div>
    </div>
        


</body>
</html>