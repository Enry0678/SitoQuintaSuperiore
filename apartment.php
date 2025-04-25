<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appartamento</title>
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
    
    $codice = $_GET["codice"];
    $checkin = $_GET["checkin"];
    $checkout = $_GET["checkout"];

    $nomeDatabase = "appartamentiDB";
    $nomeUtenteDB = "root";
    $passwordDB = "";

    $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM appartamenti WHERE codice = ?");
    $stmt->bind_param("s", $codice);
    $stmt->execute();
    $result = $stmt->get_result();

    $days = (strtotime($checkout) - strtotime($checkin)) / 86400;

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<h1>Appartamento: " . $row["nome"] . "</h1>";
            echo "<p>Proprietario: " . $row["proprietario"] . "</p>";
            echo "<p>Indirizzo: ".$row["indirizzo"]."</p>";
            echo "<p>Prezzo: " . $row["prezzo"]*$days . "€</p>";
            echo "<p>Citta: " . $row["citta"] . "</p>";
            echo "<p>Descrizione: " . $row["descrizione"] . "</p>";
            echo "<p>Numero di camere: " . $row["numero_camere"] . "</p>";
            echo "<p>Numero di letti: " . $row["numero_letti"] . "</p>";
            echo "<p>Numero di posti letto: " . $row["numero_persone"] . "</p>";
        }
    }

?>
</body>
</html>
