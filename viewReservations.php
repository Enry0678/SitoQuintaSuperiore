<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza le prenotazioni</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .centered-form-container {
            margin-top: 10px;
            padding: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .profile-card {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
            font-size: 1.8rem;
        }

        .reservation-item {
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }

        .reservation-item:last-child {
            border-bottom: none;
        }

        .reservation-item p {
            margin: 0.5rem 0;
            line-height: 1.5;
        }

        .no-reservations {
            text-align: center;
            color: #6b7280;
            padding: 2rem 0;
        }
    </style>
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
        <div class="profile-card">
            <?php
            // Connessione al database
            $nomeDatabase = "my_enricoghezzo";
            $nomeUtenteDB = "root";
            $passwordDB = "";

            $cod = $_GET['codice'];

            $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }

            $mysqli = $conn->prepare("SELECT * FROM appartamenti WHERE codice=?");
            $mysqli->bind_param("s", $cod);
            $mysqli->execute();
            $result = $mysqli->get_result();

            if($row = $result->fetch_assoc()){
                echo "<h1>Prenotazioni per l'appartamento {$row['nome']}</h1>";
            }

            $mysqli = $conn->prepare("SELECT * FROM prenotazioni WHERE appartamento=? AND prenotazioni.data_fine>=CURDATE()");
            $mysqli->bind_param("s", $cod);
            $mysqli->execute();
            $result = $mysqli->get_result();

            while($row = $result->fetch_assoc()) {
                echo "<div class='reservation-item'>";
                echo "<p><strong>Utente che ha prenotato:</strong> {$row['utente']}</p>";
                echo "<p><strong>Numero di adulti:</strong> {$row['adulti']}</p>";
                echo "<p><strong>Numero di bambini:</strong> {$row['bambini']}</p>";
                echo "<p><strong>Data di inizio:</strong> " . date_format(date_create($row["data_inizio"]), "d/m/Y") . "</p>";
                echo "<p><strong>Data di fine:</strong> " . date_format(date_create($row["data_fine"]), "d/m/Y") . "</p>";
                echo "</div>";
            }

            if($result->num_rows < 1){
                echo "<div class='no-reservations'>";
                echo "<p>Non ci sono prenotazioni per questo appartamento</p>";
                echo "</div>";
            }

            $mysqli->close();
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>