<?php
    session_start();

    //prendo i dati dal form
    $username = $_POST["username"];
    $password = $_POST["password"];
    
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
    $sql = "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    //verifico se ci sono risultati
    if($result->num_rows > 0){
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    }
    else{
        $_SESSION["error"] = "Credenziali non valide";
        header("Location: login.php");
        exit();
    }
    
?>