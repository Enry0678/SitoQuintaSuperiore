<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
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
    <h1>Account</h1>
    <?php
        if(isset($_SESSION["username"])){
            echo "<p>Ciao " . $_SESSION["username"] . "</p>";
        }

            // Connessione al database
            $nomeDatabase = "appartamentiDB";
            $nomeUtenteDB = "root";
            $passwordDB = "";

            $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }

            // Query per ottenere i dati dell'utente
            $username = $_SESSION["username"];
            $mysqli = $conn->prepare("SELECT nome, cognome, data_nascita, nazionalita, email, telefono FROM utenti WHERE username = ?");
            $mysqli->bind_param("s", $username);
            $mysqli->execute();
            $result = $mysqli->get_result();

            if($row = $result->fetch_assoc()) {
                echo "<div class='user-info'>";
                echo "<p><strong>Nome:</strong> " . htmlspecialchars($row['nome']) . "</p>";
                echo "<p><strong>Cognome:</strong> " . htmlspecialchars($row['cognome']) . "</p>";
                echo "<p><strong>Data di nascita:</strong> " . htmlspecialchars($row['data_nascita']) . "</p>";
                echo "<p><strong>Nazionalità:</strong> " . htmlspecialchars($row['nazionalita']) . "</p>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                echo "<p><strong>Telefono:</strong> " . htmlspecialchars($row['telefono']) . "</p>";
                echo "</div>";
            } else {
                echo "<p>Errore nel recupero dei dati utente.</p>";
            }

            $mysqli->close();
            $conn->close();
    ?>
    <a href="modifyProfile.php">Modifica il profilo</a>
    <a href="addApartment.php">Aggiungi un appartmento</a>
</body>
</html>