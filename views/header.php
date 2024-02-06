<header>
    <div >
        <a href="main.php" >
            <img src="../img/logoNoback.png" alt="Ritorna a main" height='60' width='60' style="margin-right: 10px;">
        </a>
        <h1>ForumFlow</h1>
    </div>
    <div >
        <a href="personal_profile.php" style="text-decoration: none; margin-right: 20px; color: #333; font-weight: bold; "><?php echo $_SESSION['user']->Username ?></a>
        <a href="../guide.html" style="margin-right: 20px; margin-left:20px; color: #333;  ">Guida al sito</a>
        <form method="post" action="main.php">
            <button type="submit" name="logout" >Logout</button>
        </form>
        
    </div>
</header>
