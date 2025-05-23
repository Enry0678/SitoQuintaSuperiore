<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="navbar-container">
                <div class="site-name">ItaliaStay</div>
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
            </div>
        </nav>
    </header>
    <div class="centered-form-container">
        <form class="auth-form" action="validateLogin.php" method="post">
            <h2>Accedi</h2>
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Accedi</button>
            <p style="text-align:center; margin-top:1rem;">Non hai un account? <a href="register.php">Registrati</a></p>
            <?php
                if(isset($_SESSION["error"])){
                    echo "<p style='color: red; text-align:center;'>" . $_SESSION["error"] . "</p>";
                    unset($_SESSION["error"]);
                }
            ?>
        </form>
    </div>
</body>
</html>