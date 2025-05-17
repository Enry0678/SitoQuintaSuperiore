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

$id = $_GET["id"];

$nomeDatabase = "appartamentiDB";
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

echo "Appartamento selezionato: <a href='apartment.php?codice={$result['codice']}&checkin={$result['data_inizio']}&checkout={$result['data_fine']}&adulti={$result['adulti']}&bambini={$result['bambini']}'>{$result['nome']}</a> <br>";
echo "Numero di adulti: {$result['adulti']} <br>";
echo "Numero di bambini: {$result['bambini']} <br>";
echo "Data di checkin: {$data_inizio} <br>";
echo "Data di checkout {$data_fine} <br>";
echo "Scarica il pdf con i dati della tua prenotazione <a href='PDFPrenotazione.php?codice={$result['codice']}'>qui</a><br>";

$data_inizio = new DateTime($result['data_inizio']);
$adesso = new DateTime();
$adesso->format('Y-m-d');
$giorni = $data_inizio->diff($adesso)->days;
if($giorni > 7){
    echo "<form action='deleteReservation.php?codice={$id}' method='get' onsubmit='return confirm(\"Sei sicuro di voler cancellare questa prenotazione?\");'>";
    echo "<input type='submit' value='Cancella la prenotazione' id='cancButton'>";
    echo "</form>";
}
else{
    echo "La prenotazione non è più cancellabile";
}
?>
</body>
</html>