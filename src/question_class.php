<?php
require_once 'user_class.php';
require_once 'answer_class.php';
require_once 'access_db.php';
class Question {
    public $id;
    public $author; # username
    public $body;   # testo
    public $insertTimestamp; 
    public $category; # nome della categoria

    public function __construct($id, $author, $body, $category, $insertTimestamp = null) {
        $this->id = $id;
        $this->author = $author;
        $this->body = $body;
        $this->insertTimestamp = $insertTimestamp;
        $this->category = $category;
    }

    public function validation() {
        if($this->body === "") {
            return "Corpo vuoto";
        }
        if(strlen($this->body) >= 255) {
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
                  FROM question 
                  WHERE question.Id = ?";

        $statement = $conn->prepare($query);
        $statement->bind_param("s", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        if($result->num_rows == 0) return NULL;
        $row = $result->fetch_assoc();
        $conn->close();
        $question_found = new Question($row['Id'], $row['Author'], $row['Body'], $row['Category'], $row['InsertTimestamp']);
        return $question_found;
    }

    public function saveToDatabase() {
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }

        $sql = "INSERT INTO question (Author, Body, InsertTimestamp, Category) 
                  VALUES (?, ?, NOW(), ?)";
        
        $statement = $conn->prepare($sql);
        $statement->bind_param("sss", $this->author, $this->body, $this->category);
        $success = $statement->execute();
        $statement->close();
        
        if ($success) {
            $conn->close();
            return true;
        }
        else {
            $conn->close();
            return false;
        }
    }
    public function getAnswers() {
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);      
          // Verifica la connessione
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }
        $sql = "
        SELECT *
        FROM answer
        WHERE Question = ?
        ORDER BY InsertTimestamp DESC
        LIMIT 5;
        ";

        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $this->id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result;
    }
    public function getAnswersHTML() {
        $result = $this->getAnswers();
        while($row = $result->fetch_assoc()) {
            $answer_found = new Answer($row['Id'], $row['Question'], $row['Author'], $row['Body'], $row['InsertTimestamp']);
            $answer_found->toHTML();
        }
    }
    //come deve apparire in main
    public function toHTML_inMain() {
        
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
        // Verifica la connessione
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }
        $sql = "SELECT ImgPath FROM category WHERE Name = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $this->category);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        $row = $result->fetch_assoc();
        $pathFoundCat = $row['ImgPath'];

        $sql = "SELECT ImgPath FROM user WHERE Username = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $this->author);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        $row = $result->fetch_assoc();
        $pathFoundAuthor = $row['ImgPath'];

        if($pathFoundAuthor === null) $pathFoundAuthor = '../img/profiles/default.jpg';

        
        $html = "
        <div class='question-container'>
            <div class='question-category'>
                <img src='" . $pathFoundCat . "' alt='cat' width='40' height='40'>
                <p> " . $this->category . "</p>
            </div>
            <div class='question-content'>
                <div class='user-info'>
                    <img src='" . $pathFoundAuthor . "' alt='img_user' class='rounded-image'>
                    <p> <a href='profile.php?username=" . $this->author . "'>". $this->author . "</a></p>
                </div>
                <p class='question-body'><a href='question.php?id=" . $this->id . "'>". nl2br($this->body) . "</a></p>
                <p class='timestamp'> " . $this->insertTimestamp . "</p>
            </div>
        </div>";
        return $html;
    }
    //come deve apparire in quetsion
    public function toHTML_inQuestion() {
        // Connetti al database
        
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
        // Verifica la connessione
        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }
        $sql = "SELECT ImgPath FROM category WHERE Name = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $this->category);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        $row = $result->fetch_assoc();
        $pathFoundCat = $row['ImgPath'];
        
        $sql = "SELECT ImgPath FROM user WHERE Username = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $this->author);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        $row = $result->fetch_assoc();
        $pathFoundAuthor = $row['ImgPath'];

        if($pathFoundAuthor === null) $pathFoundAuthor = '../img/profiles/default.jpg';


        $html = "
            <div class='question-container'>
                <div class='question-category'>
                    <img src='" . $pathFoundCat . "' alt='cat' width='40' height='40'>
                    <p>" . $this->category . "</p>
                </div>
                <div class='question-content'>
                    <div class='user-info'>
                        <img src='" . $pathFoundAuthor . "' alt='img_user' class='rounded-image'>
                        <p> <a href='profile.php?username=" . $this->author . "'>". $this->author . "</a></p>
                    </div>
                    <p class='question-body-big'>" . nl2br($this->body) . "</p>
                    <p class='timestamp'> " . $this->insertTimestamp . "</p>
                </div>
            </div>";
        return $html;
    }
}

?>
