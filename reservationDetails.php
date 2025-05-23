<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli prenotazione</title>
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
        <h2>Dettagli della prenotazione</h2>
        <?php
            $id = $_GET["id"];

            $nomeDatabase = "my_enricoghezzo";
            $nomeUtenteDB = "root";
            $passwordDB = "";

            $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT prenotazioni.*, appartamenti.nome, appartamenti.codice FROM prenotazioni INNER JOIN appartamenti ON prenotazioni.appartamento = appartamenti.codice WHERE prenotazioni.id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();

            $data_inizio = date_format(date_create($result['data_inizio']), "d/m/Y");
            $data_fine = date_format(date_create($result['data_fine']), "d/m/Y");

            echo "<div class='profile-info'>";
            echo "<div><strong>Appartamento:</strong> <a href='apartment.php?codice={$result['codice']}&checkin={$result['data_inizio']}&checkout={$result['data_fine']}&adulti={$result['adulti']}&bambini={$result['bambini']}'>" . htmlspecialchars($result['nome']) . "</a></div>";
            echo "<div><strong>Numero di adulti:</strong> " . htmlspecialchars($result['adulti']) . "</div>";
            echo "<div><strong>Numero di bambini:</strong> " . htmlspecialchars($result['bambini']) . "</div>";
            echo "<div><strong>Data di check-in:</strong> " . $data_inizio . "</div>";
            echo "<div><strong>Data di check-out:</strong> " . $data_fine . "</div>";
            echo "</div>";

            echo "<div style='text-align:center; margin-top:1.5rem;'>";
            echo "<div style='margin-bottom: 1rem;'>";
            echo "<a href='PDFPrenotazione.php?codice={$result['codice']}' class='btn-primary' style='margin: 0 1rem;'>Scarica PDF prenotazione</a>";
            
            $data_inizio = new DateTime($result['data_inizio']);
            $adesso = new DateTime();
            $adesso->format('Y-m-d');
            $giorni = $data_inizio->diff($adesso)->days;
            
            if($giorni > 7){
                echo "<a href='deleteReservation.php?codice={$id}' onclick='return confirm(\"Sei sicuro di voler cancellare questa prenotazione?\");' class='btn-primary' style='background-color: #dc3545; margin: 0 1rem;'>Cancella la prenotazione</a>";
            }
            echo "</div>";
            
            echo "<a href='account.php' class='btn-primary' style='margin: 0 1rem;'>Torna al profilo</a>";
            echo "</div>";
        ?>
    </div>
</body>
</html>