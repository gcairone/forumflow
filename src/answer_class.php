<?php
require_once 'access_db.php';

class Answer {
    public $id;
    public $question; # id della question 
    public $author; # testo 
    public $body;   # testo 
    public $insertTimestamp; 

    public function __construct($id, $question, $author, $body, $insertTimestamp = null) {
        $this->id = $id;
        $this->question = $question;
        $this->author = $author;
        $this->body = $body;
        $this->insertTimestamp = $insertTimestamp;
    }

    public function validation() {
        if($this->body === "") {
            return "Corpo vuoto";
        }
        if(strlen($this->body) >= 1000) {
            return "Corpo troppo lungo";
        }
        return true;
    }


    public static function findById($id) {
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);

        // Verifica la connessione
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
            return null;
        }

        $query = "SELECT *
                  FROM answer 
                  WHERE Id = ?";

        $statement = $conn->prepare($query);
        $statement->bind_param("s", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        if($result->num_rows == 0) return NULL;
        $row = $result->fetch_assoc();
        $conn->close();
        $question_found = new Question($row['Id'], $row['Question'], $row['Author'], $row['Body'], $row['InsertTimestamp']);
        return $question_found;
    }

    public function saveToDatabase() {
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);

        // Verifica la connessione
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }

        $sql = "INSERT INTO answer (Question, Author, Body, InsertTimestamp) 
                  VALUES (?, ?, ?, NOW())";
        
        $statement = $conn->prepare($sql);
        $statement->bind_param("sss", $this->question, $this->author, $this->body);
        $success = $statement->execute();
        $statement->close();

        if ($success !== false) {
            $conn->close();
            return true;
        }
        else {
            $conn->close();
            return false;
        }
        return false;
    }
    public function toHTML() {
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }
        $query = "SELECT ImgPath FROM user WHERE Username = ?";

        $statement = $conn->prepare($query);
        $statement->bind_param("s", $this->author);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        $row = $result->fetch_assoc();
        $profile_img = $row['ImgPath'];
        if($profile_img === null) $profile_img = '../img/profiles/default.jpg';

        $html = "
            <div class='response-container'>
                <div class='user-info'>
                    <img src='" . $profile_img . "' alt='img_user' class='rounded-image'>
                    <p> <a href='profile.php?username=" . $this->author . "'>". $this->author . "</a></p>
                </div>
                <p class='response-body'>" . nl2br($this->body) . "</p>
                <p class='timestamp'> " . $this->insertTimestamp . "</p>
            </div>
            ";
        echo $html;
    }
}

?>



