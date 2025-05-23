<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appartamenti trovati</title>
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
<div class="results-container">
<?php
    $city = $_GET["city"];
    $checkin = $_GET["checkin"];
    $checkout = $_GET["checkout"];
    $persone = (int)$_GET["adulti"] + (int)$_GET["bambini"];
    $camere = (int)$_GET["camere"];
    $letti = (int)$_GET["letti"];

    $nomeDatabase = "my_enricoghezzo";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM appartamenti WHERE citta = ? AND numero_camere = ? AND numero_letti = ? AND numero_persone >= ?");
    $stmt->bind_param("siii", $city, $camere, $letti, $persone);
    $stmt->execute();
    $result = $stmt->get_result();

    $days = (strtotime($checkout) - strtotime($checkin)) / 86400;

    $tipo_mime = 'image/jpeg';
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<div class='apartment-card'>";
            // Immagine placeholder
            $base64_immagine = base64_encode($row["immagine1"]);
            echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' width='300' height='300'><br>";
            echo "<div class='apartment-info'>";
            echo "<h3>" . htmlspecialchars($row["nome"]) . "</h3>";
            echo "<p>" . htmlspecialchars($row["numero_camere"]) . " camere · " . htmlspecialchars($row["numero_letti"]) . " letti · Max " . htmlspecialchars($row["numero_persone"]) . " persone</p>";
            echo "<div class='apartment-price'>" . ($row["prezzo"]*$days*$persone) . "€ totali</div>";
            echo "<a href='apartment.php?codice={$row["codice"]}&checkin={$checkin}&checkout={$checkout}&adulti={$_GET['adulti']}&bambini={$_GET['bambini']}' class='btn-primary'>Dettagli</a>";
            echo "</div></div>";
        }
    }
    else{
        echo "<p>Nessun appartamento trovato</p>";
    }

?>
</div>
</body>
</html>