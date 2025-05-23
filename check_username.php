<?php

// Check if username is provided
if(isset($_POST['username'])) {
    $username = $_POST['username'];

    $nomeDatabase = "my_enricoghezzo";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    //connessione al database
    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM utenti WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Return JSON response
    header('Content-Type: application/json');
    if($row['count'] > 0) {
        echo json_encode(['exists' => true, 'message' => 'Username già in uso']);
    } else {
        echo json_encode(['exists' => false, 'message' => 'Username disponibile']);
    }
    
    $stmt->close();
    $conn->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Username non fornito']);
}
?> 