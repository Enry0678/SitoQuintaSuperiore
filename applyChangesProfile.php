<?php
    session_start();
    
    $nomeDatabase = "my_enricoghezzo";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    //connessione al database
    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    //recupero i dati dell'utente
    $sql = $conn->prepare("SELECT * FROM utenti WHERE username=?;");
    $sql->bind_param("s", $_SESSION["username"]);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    $password = "";
    $email = "";
    $telefono = "";
    if($_POST["password"] != ""){
        $password = hash("sha256", $_POST["password"]);
    }
    else{
        $password = $row["password"];
    }

    if($_POST["email"] != ""){
        $email = $_POST["email"];
    }
    else{
        $email = $row["email"];
    }

    if($_POST["telefono"] != ""){
        $telefono = $_POST["telefono"];
    }
    else{
        $telefono = $row["telefono"];
    }
    

    //query per verificare le credenziali
    $sql = $conn->prepare("UPDATE utenti SET password=?, email=?, telefono=? WHERE username=?;");
    $sql->bind_param("ssss", $password, $email, $telefono, $_SESSION["username"]);

    if($sql->execute()) {
        header("Location: account.php");
        exit();
    } else {
        $_SESSION["error"] = "Errore durante l'aggiornamento del profilo: " . $sql->error;
        header("Location: account.php");
        exit();
    }
?>