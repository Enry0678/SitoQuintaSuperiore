<?php
    session_start();

    $codice = $_GET['codice'];
    $adulti = $_GET['adulti'];
    $bambini = $_GET['bambini'];
    $data_inizio = $_GET['data_inizio'];
    $data_fine = $_GET['data_fine'];

    $nomeDatabase = "appartamentiDB";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO prenotazioni (appartamento, utente, adulti, bambini, data_inizio, data_fine) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $codice, $_SESSION["username"], $adulti, $bambini, $data_inizio, $data_fine);
    $stmt->execute();

    header("Location: reservationConfirmed.php");
    exit;
?>