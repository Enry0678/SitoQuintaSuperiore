<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
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
    <div class="profile-card">
        <h2>Il tuo profilo</h2>
        <?php
            if(isset($_SESSION["username"])){
                echo "<div class='profile-info'>Ciao <strong>" . $_SESSION["username"] . "</strong></div>";
            }

            // Connessione al database
            $nomeDatabase = "my_enricoghezzo";
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
                echo "<div class='profile-info'>";
                echo "<div><strong>Nome:</strong> " . htmlspecialchars($row['nome']) . "</div>";
                echo "<div><strong>Cognome:</strong> " . htmlspecialchars($row['cognome']) . "</div>";
                echo "<div><strong>Data di nascita:</strong> " . htmlspecialchars($row['data_nascita']) . "</div>";
                echo "<div><strong>Nazionalità:</strong> " . htmlspecialchars($row['nazionalita']) . "</div>";
                echo "<div><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</div>";
                echo "<div><strong>Telefono:</strong> " . htmlspecialchars($row['telefono']) . "</div>";
                echo "</div>";
            } else {
                echo "<p>Errore nel recupero dei dati utente.</p>";
            }
        ?>
        <div style="text-align:center; margin:1.2rem 0;">
            <a href="modifyProfile.php" class="btn-primary">Modifica il profilo</a>
            <a href="manageApartments.php" class="btn-primary" style="margin-left:0.7rem;">Gestisci i tuoi appartamenti</a>
        </div>
        <h3>Le tue prenotazioni attive</h3>
        <table class="booking-table">
            <tbody>
                <?php
                $utente=$_SESSION["username"];
                $query = $conn->prepare("SELECT * FROM prenotazioni WHERE utente = ? AND data_inizio > CURDATE()");
                $query->bind_param("s", $utente);
                $query->execute();
                $result = $query->get_result();
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='reservationDetails.php?id={$row['id']}'>Prenotazione #" . $row['id'] . "</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <h3>Le tue prenotazioni in corso</h3>
        <table class="booking-table">
            <tbody>
                <?php
                $utente=$_SESSION["username"];
                $query = $conn->prepare("SELECT * FROM prenotazioni WHERE utente = ? AND (CURDATE() BETWEEN data_inizio AND data_fine)");
                $query->bind_param("s", $utente);
                $query->execute();
                $result = $query->get_result();
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='reservationDetails.php?id={$row['id']}'>Prenotazione #" . $row['id'] . "</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <h3>Le tue prenotazioni terminate</h3>
        <table class="booking-table">
            <tbody>
                <?php
                $utente=$_SESSION["username"];
                $query = $conn->prepare("SELECT * FROM prenotazioni WHERE utente = ? AND data_fine < CURDATE()");
                $query->bind_param("s", $utente);
                $query->execute();
                $result = $query->get_result();
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='reservationDetails.php?id={$row['id']}'>Prenotazione #" . $row['id'] . "</a></td>";
                    echo "</tr>";
                }
                $mysqli->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>