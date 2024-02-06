<?php
require_once 'access_db.php';


class User {
    public $Username;
    public $Email;
    public $Password;
    public $AdditionalInfo;
    public $ImgPath;
    public $JoinedDateTime;

    public function __construct($Username, $Email, $Password, $AdditionalInfo, $ImgPath, $JoinedDateTime = null) {
        $this->Username = $Username;
        $this->Email = $Email;
        $this->Password = $Password;
        $this->JoinedDateTime = $JoinedDateTime;
        $this->ImgPath = $ImgPath;
        $this->AdditionalInfo = $AdditionalInfo;
    }

    public function validation() {
        if($this->Username === "") {
            return "Username obbligatorio";
        }
        if(strlen($this->Username) >= 20) {
            return "Username troppo lungo";
        }
        if(!preg_match('/^[a-zA-Z0-9_-]+$/', $this->Username)) {
            return "Caratteri speciali non consentiti";
        }
        if($this->Email === "") {
            return "Email obbligatoria";
        }
        if(strlen($this->Email) >= 50) {
            return "Email troppo lunga";
        }
        if(!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $this->Email)) {
            return "Caratteri speciali non consentiti";
        }
        if(strlen($this->AdditionalInfo) >= 256) {
            return "Info troppo lunghe";
        }

        
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);

        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
        
        // Controlla se esistono account con la stessa email
        $query = "SELECT * FROM user WHERE Email = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param("s", $this->Email);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        if($result->num_rows > 0) {
            $conn->close();
            return "Email già in uso";
        }

        // Controlla se esistono account con lo stesso nome utente
        $query = "SELECT * FROM user WHERE Username = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param("s", $this->Username);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        if($result->num_rows > 0) {
            $conn->close();
            return "Username già in uso";
        }
        return true;
    }

    public function saveToDatabase() {
        // Connessione al database 

        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO user (Username, Email, Password, AdditionalInfo, ImgPath, JoinedDateTime)
                VALUES (?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE
                    Username = VALUES(Username),
                    Email = VALUES(Email),
                    Password = VALUES(Password),
                    AdditionalInfo = VALUES(AdditionalInfo), 
                    ImgPath = VALUES(ImgPath);";
        $statement = $conn->prepare($sql);
        $statement->bind_param("sssss", $this->Username, $this->Email, $this->Password, $this->AdditionalInfo, $this->ImgPath);
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
        $profile_img = $this->ImgPath;
        if($this->ImgPath === null) $profile_img = '../img/profiles/default.jpg';
        $dateTimeObject = new DateTime($this->JoinedDateTime);
        $dateOnly = $dateTimeObject->format('Y-m-d');

        $html = "
            <div class='user-container'>
                <div class='user-image'>
                    <img src='" . $profile_img . "' alt='img_user' width='80' height='80' class='rounded-image'>
                </div>
                <div class='user-info'>
                    <p><strong> Username: </strong>" . $this->Username . "</p>
                    <p><strong> Email: </strong>" . $this->Email . "</p>
                    <p><strong> Data di registrazione: </strong>" . $dateOnly . "</p>
                    <span><strong> Informazioni aggiuntive: <br> </strong>" . nl2br($this->AdditionalInfo) . "</span>
                </div>
            </div>";
        return $html;
    }
    
    public static function findByUsername($username) {
        
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            return NULL;
        }

        $query = "SELECT * FROM user WHERE Username = ?";

        $statement = $conn->prepare($query);

        if (!$statement) {
            die("Errore nella preparazione della query: " . $conn->error);
            return NULL;
        }

        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        if($result->num_rows == 0) return NULL;
        $row = $result->fetch_assoc();
        $conn->close();
        $user_found = new User($row['Username'], $row['Email'], $row['Password'], $row['AdditionalInfo'], $row['ImgPath'], $row['JoinedDateTime']);

        return $user_found;
    }

}
?>
