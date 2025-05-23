<?php

$id_prenotazione = $_GET["codice"];

$nomeDatabase = "my_enricoghezzo";
$nomeUtenteDB = "root";
$passwordDB = "";

$conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM prenotazioni WHERE id = ?");
$stmt->bind_param("s", $id_prenotazione);
$stmt->execute();

header("Location: index.php");

?>
