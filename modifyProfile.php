<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica account</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <?php 
                    session_start();
                    if(isset($_SESSION["username"])){
                        echo "<li><a href='index.php'>Home</a></li>";
                        echo "<li><a href='account.php'>Profilo</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                    else{
                        echo "<li><a href='index.php'>Home</a></li>";
                        echo "<li><a href='login.php'>Login</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </header>

    <form action="applyChangesProfile.php" method="post">
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" placeholder="nuova password"><br>
        <input type="password" name="password_check" id="password_check" placeholder="conferma nuova password"><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" placeholder="nuova email"><br>
        <label for="telefono">Telefono:</label><br>
        <input type="tel" name="telefono" id="telefono"><br><br>
        <input type="submit" value="Conferma le modifiche">
    </form>
</body>
</html>