<?php
    session_start();

    //prendo i dati dal form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $data_nascita = $_POST["data_nascita"];
    $nazionalita = $_POST["nazionalita"];
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

    // Utilizzo prepared statement per prevenire SQL injection
    $stmt = $conn->prepare("INSERT INTO utenti (username, password, nome, cognome, data_nascita, nazionalita, email, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $username, $password, $nome, $cognome, $data_nascita, $nazionalita, $email, $telefono);
    
    // Eseguo la query
    if($stmt->execute()) {
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["error"] = "Errore durante la registrazione: " . $stmt->error;
        header("Location: register.php");
        exit();
    }
    
    // Chiudo lo statement e la connessione
    $stmt->close();
    $conn->close();
?>