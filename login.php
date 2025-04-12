<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="validateLogin.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">Login</button>
    </form>
    <p>Non hai un account? <a href="register.php">Registrati</a></p>
    <?php
        if(isset($_SESSION["error"])){
            echo "<p style='color: red;'>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]);
        }
    ?>
</body>
</html>