<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appartamenti trovati</title>
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

    $city = $_GET["city"];
    $checkin = $_GET["checkin"];
    $checkout = $_GET["checkout"];

    $nomeDatabase = "appartamentiDB";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM appartamenti WHERE citta = ?");
    $stmt->bind_param("s", $city);
    $stmt->execute();
    $result = $stmt->get_result();

    $days = (strtotime($checkout) - strtotime($checkin)) / 86400;

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<strong>Appartamento: <a href='apartment.php?codice=" . $row["codice"] . "&checkin=" . $checkin . "&checkout=" . $checkout . "'>" . $row["nome"] . "</a></strong>";
            echo "<p>Prezzo: " . $row["prezzo"]*$days . "€</p>";
        }
    }
    else{
        echo "<p>Nessun appartamento trovato</p>";
    }

?>
</body>
</html>