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

        //visualizzazione immagini
        $tipo_mime = 'image/jpeg';
        if ($row["immagine1"] !== "") {
            $base64_immagine = base64_encode($row["immagine1"]);
            echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' width='300' height='300'><br>";
        } else {
            echo "Nessuna immagine 1<br>";
        }

        if ($row["immagine2"] !== "") {
            $base64_immagine = base64_encode($row["immagine2"]);
            echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' width='300' height='300'><br>";
        } else {
            echo "Nessuna immagine 2<br>";
        }
        if ($row["immagine3"] !== "") {
            $base64_immagine = base64_encode($row["immagine3"]);
            echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' width='300' height='300'><br>";
        } else {
            echo "Nessuna immagine 3<br>";
        }

        //visualizzazione dei servizi
        echo "<h3>Servizi inclusi:</h3>";
        $queryServizi = $conn->prepare("SELECT nome, simbolo FROM servizi INNER JOIN axs ON servizi.nome=axs.servizio WHERE axs.appartamento = ?");
        $queryServizi->bind_param("s", $codice);
        $queryServizi->execute();
        $resultServizi = $queryServizi->get_result();

        if ($resultServizi->num_rows > 0) {
            echo "<ul>";
            while ($rowServizio = $resultServizi->fetch_assoc()) {
                echo "<li>{$rowServizio["nome"]} {$rowServizio["simbolo"]}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Nessun servizio disponibile per questo appartamento.</p>";
        }
        $queryServizi->close();
    }
}
    $adulti = $_GET["adulti"];
    $bambini = $_GET["bambini"];

    $stmt = $conn->prepare("SELECT *
FROM prenotazioni
WHERE appartamento = ?
  AND (
    -- Caso: uguale
    (data_inizio = ? AND data_fine = ?)
    
    OR
    
    -- Caso: esterno (completamente contenuta nel nuovo intervallo)
    (? < data_inizio AND data_fine < ?)
    
    OR

    -- Caso: da in mezzo a dopo
    (data_inizio < ? AND data_fine < ?)
    
    OR
    
    -- Caso: da prima ad in mezzo
    (? < data_inizio AND ? < data_fine)

    OR
    
    -- Caso: tutto interno (prenotazione esistente contiene il nuovo intervallo)
    (data_inizio < ? AND ? < data_fine)
  );
");
    $stmt->bind_param("sssssssssss", $codice, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        var_dump($row);
    }

    if($result->num_rows == 0){
        echo "<form action='reservation.php?codice={$codice}&checkin={$checkin}&checkout={$checkout}&adulti={$adulti}&bambini={$bambini}' method='post'>";
        echo "   <input type='submit' value='Prenota ora'>";
        echo "</form>";
    }
    else{
        echo "L'appartamento è già stato prenotato per queste date";
    }

?>

</body>
</html>