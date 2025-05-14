<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli prenotazione</title>
</head>
<body>

<?php
session_start();

//header
echo "<header>";
if(isset($_SESSION["username"])){
    echo "<li><a href='index.php'>Home</a></li>";
    echo "<li><a href='account.php'>Profilo</a></li>";
    echo "<li><a href='logout.php'>Logout</a></li>";
}
else{
    echo "<li><a href='index.php'>Home</a></li>";
    echo "<li><a href='login.php'>Login</a></li>";
}
echo "</header>";
?>

<h1>Dettagli della penotazione</h1>

<?php

$codice = $_GET["id"];

$nomeDatabase = "appartamentiDB";
$nomeUtenteDB = "root";
$passwordDB = "";

$conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT prenotazioni.*, appartamenti.nome FROM prenotazioni INNER JOIN appartamenti ON prenotazioni.appartamento = appartamenti.codice WHERE prenotazioni.id = ?");
$stmt->bind_param("s", $codice);
$stmt->execute();
$result = $stmt->get_result();
$result = $result->fetch_assoc();

$data_inizio = date_format(date_create($result['data_inizio']), "d/m/Y");
$data_fine = date_format(date_create($result['data_fine']), "d/m/Y");

echo "Utente che effettua la prenotazione: {$result['utente']} <br>";
echo "Appartamento selezionato: {$result['nome']} <br>";
echo "Numero di adulti: {$result['adulti']} <br>";
echo "Numero di bambini: {$result['bambini']} <br>";
echo "Data di checkin: {$data_inizio} <br>";
echo "Data di checkout {$data_fine} <br>";

?>
</body>
</html>