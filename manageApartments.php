<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestisci i tuoi appartamenti</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <?php
            session_start();
            if(isset($_SESSION["username"])){
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='account.php'>Profilo</a></li>";
                echo "<li><a href='logout.php'>Logout</a></li>";
            }
            else{
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='login.php'>Login</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>
<h1>Gestisci i tuoi appartamenti</h1>
<h2>Appartamenti</h2>
<?php
// Connessione al database
$nomeDatabase = "appartamentiDB";
$nomeUtenteDB = "root";
$passwordDB = "";

$conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION["username"];
$mysqli = $conn->prepare("SELECT * FROM appartamenti WHERE proprietario=?");
$mysqli->bind_param("s", $username);
$mysqli->execute();
$result = $mysqli->get_result();

while($row = $result->fetch_assoc()) {
    echo "<a href='apartment.php?codice={$row['codice']}'>{$row['nome']}</a> | <a href='viewReservations.php?codice={$row['codice']}'>visualizza le prenotazioni</a><br>";
}

if($result->num_rows < 1){
    echo "<p>Non hai ancora registrato un appartamento</p>";
}

echo "<h2>Aggiungi un appartamento</h2>";

echo "<form action='addApartmentForm.php' method='get'>";
echo "   <input type='submit' value='Aggiungi un appartamento'>";
echo "</form>";
$mysqli->close();
$conn->close();
?>
</body>
</html>