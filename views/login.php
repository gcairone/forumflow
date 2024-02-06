<?php
require_once '../src/user_class.php';
session_start();
require_once '../src/access_db.php';


// Connessione al database
$conn = new mysqli($GLOBALS['servername'], $GLOBALS['usernameDB'], $GLOBALS['passwordDB'], $GLOBALS['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = User::findByUsername($username);
    
    if ($result != NULL && password_verify($password, $result->Password)) {
        $_SESSION["user"] = $result;
        header("Location: main.php");
        exit();
    } else {
        $message = "Username o password errati";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForumFlow - Log in</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="background">
        <div class="container" id="login-box">
            <h1>ForumFlow - Log in</h1>
            <br>
            
            <div >
                <form method="post" class="grid-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" maxlength="20" required>
                
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" maxlength="50" required>

                    <button type="submit" class="btn">Log in</button>
                </form>
                <p><?php if(isset($message)) echo $message; ?></p>
            </div>
        </div>

    </div>

</body>
</html>
