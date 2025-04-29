<?php
    session_start();

    //prendo i dati dal form
    $password = $_POST["password"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    
    $nomeDatabase = "appartamentiDB";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    //connessione al database
    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    //preparo la password per la query
    $password = hash("sha256", $password);

    //query per verificare le credenziali
    $sql = "UPDATE (password, email, telefono) VALUES (?,?,?) WHERE username=?;";
    $sql->bind_param("ssss", hash("sha256", $password), $email, $telefono, $_SESSION["username"]);

    if($sql->execute()) {
        header("Location: account.php");
        exit();
    } else {
        $_SESSION["error"] = "Errore durante l'aggiornamento del profilo: " . $sql->error;
        header("Location: account.php");
        exit();
    }
?>