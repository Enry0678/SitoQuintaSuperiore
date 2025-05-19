<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza le prenotazioni</title>
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

<?php
// Connessione al database
$nomeDatabase = "appartamentiDB";
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
    echo "<div>";
    echo "Utente che ha prenotato: {$row['utente']}<br>";
    echo "Numero di adulti: {$row['adulti']}<br>";
    echo "Numero di bambini: {$row['bambini']}<br>";
    echo "Data di inizio: {$row['data_inizio']}<br>";
    echo "Data di fine: {$row['data_fine']}<br><br>";
    echo "</div>";
}

if($result->num_rows < 1){
    echo "<p>Non hai prenotazioni per questo appartamento</p>";
}

$mysqli->close();
$conn->close();
?>
</body>
</html>