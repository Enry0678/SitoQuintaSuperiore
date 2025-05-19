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
$checkin = isset($_GET["checkin"]) ? $_GET["checkin"] : null;
$checkout = isset($_GET["checkout"]) ? $_GET["checkout"] : null;
$adulti = isset($_GET["adulti"]) ? (int)$_GET["adulti"] : 1;
$bambini = isset($_GET["bambini"]) ? (int)$_GET["bambini"] : 0;

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

if ($checkin && $checkout) {
    $date1 = DateTime::createFromFormat('Y-m-d', $checkin);
    $date2 = DateTime::createFromFormat('Y-m-d', $checkout);
    if ($date1 && $date2) {
        $diff = $date2->diff($date1)->days;
        $giorni = ($diff > 0) ? $diff : 1; // minimo 1 giorno
    } else {
        $giorni = 1;
    }
} else {
    $giorni = 1;
}

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<h1>Appartamento: " . $row["nome"] . "</h1>";
        echo "<p>Proprietario: " . $row["proprietario"] . "</p>";

        $stmt = $conn->prepare("SELECT * FROM utenti WHERE username = ?");
        $stmt->bind_param("s", $row['proprietario']);
        $stmt->execute();
        $result1 = $stmt->get_result();
        $row1 = $result1->fetch_assoc();

        echo "<p>Contatto del proprietario: {$row1['telefono']}</p>";
        echo "<p>Indirizzo: ".$row["indirizzo"]."</p>";
        echo "<p>Prezzo: " . $row["prezzo"]*$giorni*($adulti+$bambini). "€</p>";
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

    $stmt = $conn->prepare("
SELECT *
FROM prenotazioni
WHERE appartamento = ?
  AND (
    (data_inizio < ? AND data_fine > ?) -- Caso 1a: Contenimento stretto
    OR
    (data_inizio <= ? AND data_fine >= ? AND NOT (data_inizio < ? AND data_fine > ?)) -- Caso 1b: Contenimento con almeno un bordo coincidente
    OR
    (data_fine BETWEEN ? AND ?)       -- Caso 2: Fine esistente dentro il nuovo periodo
    OR
    (data_inizio BETWEEN ? AND ?)     -- Caso 3: Inizio esistente dentro il nuovo periodo
    OR
    ((data_inizio BETWEEN ? AND ?) AND (data_fine BETWEEN ? AND ?)) -- Caso 4: Esistente interamente dentro il nuovo periodo
  );
");
    $stmt->bind_param("sssssssssssssss", $codice,
        $checkin, $checkout,    //caso 1a
        $checkin, $checkout, $checkin, $checkout, //casi 1b
        $checkin, $checkout, //caso 2
        $checkin, $checkout, //caso 3
        $checkin, $checkout, $checkin, $checkout //caso 4
    );
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        echo "<a href='reservation.php?codice={$codice}&checkin={$checkin}&checkout={$checkout}&adulti={$adulti}&bambini={$bambini}'>";
        echo "   <button>Prenota ora</button>";
        echo "</a>";
    }
    else{
        echo "L'appartamento è già stato prenotato per queste date";
    }

?>

</body>
</html>