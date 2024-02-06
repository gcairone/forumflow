<?php 
require_once 'question_class.php';
require_once 'user_class.php';
require_once 'access_db.php';


function getQuestions($start_from, $per_page) {
    // Connetti al database
    
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
    // Verifica la connessione
    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }
    //$getParameters = array_keys($_GET);
    $getParameters = array_keys(array_diff_key($_GET, array('page' => '')));

    $sql = "SELECT Name FROM category";
    $result_cat = $conn->query($sql);
    
    $categoryNamesArray = array_column($result_cat->fetch_all(MYSQLI_ASSOC), 'Name');

    if(!empty(array_diff($getParameters, $categoryNamesArray))) {
        echo "URL inconsistente";
        return 1;
    }

    $categorie_condition = implode("', '", $getParameters);
    if(count($getParameters) === 0) {
        $sql = "
        SELECT *
        FROM question
        ORDER BY InsertTimestamp DESC
        ";
    } 
    else {
        $sql = "
        SELECT *
        FROM question
        WHERE category IN ('$categorie_condition')
        ORDER BY InsertTimestamp DESC
        ";
        
    }
    $result = $conn->query($sql);
    $total_pages = ceil($result->num_rows / $per_page);

    if($result !== false) {
        if($result->num_rows != 0) {
            for ($i = $start_from; $i < $start_from + $per_page; $i++) {
                if ($i < $result->num_rows) {
                    $result->data_seek($i);
            
                    $row = $result->fetch_assoc();
            
                    $question_found = new Question($row['Id'], $row['Author'], $row['Body'], $row['Category'], $row['InsertTimestamp']);
                    echo $question_found->toHTML_inMain();
    
                } else break;
                
            }
            
            for ($i = 1; $i <= $total_pages; $i++) {
                $queryString = $_SERVER['QUERY_STRING'];
                $queryString = preg_replace('/&?page=\d+/', '', $queryString);

                $queryString .= "&page=$i";

                $queryString = ltrim($queryString, '&');
                $url = strtok($_SERVER["REQUEST_URI"], '?') . '?' . $queryString;

                echo "<a href='$url'>$i</a> ";
            }
            
        }
        else echo "Nessuna domanda in evidenza";
    }
    else echo "Errore, riprovare più tardi";
}

function getUserQuestions() {

    
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
    // Verifica la connessione
    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $sql = "
    SELECT *
    FROM question
    WHERE Author = ?
    ORDER BY InsertTimestamp DESC
    LIMIT 5;
    ";

    $statement = $conn->prepare($sql);
    $statement->bind_param("s", $_SESSION['user']->Username);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    if($result !== false) {
        if($result->num_rows != 0) {
            while($row = $result->fetch_assoc()) {
                $question_found = new Question($row['Id'], $row['Author'], $row['Body'], $row['Category'], $row['InsertTimestamp']);
                echo $question_found->toHTML_inMain();
            }
        }
        else echo "Nessuna domanda in evidenza";
    }
    else echo "Problemi nella query";
    
}
?>