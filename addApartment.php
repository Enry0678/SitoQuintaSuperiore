<?php
session_start();

$nome = $_POST['nome'];
$citta = $_POST['citta'];
$indirizzo = $_POST['indirizzo'];
$numero_camere = $_POST['numero_camere'];
$numero_letti = $_POST['numero_letti'];
$numero_persone = $_POST['posti_letto'];
$prezzo = $_POST['prezzo'];
$descrizione = $_POST['descrizione'];

$serviziSelezionati = isset($_POST['servizi']) ? $_POST['servizi'] : [];

// Leggi contenuto immagini
function getFileContent($file) {
    if ($file != null && $file['error'] === UPLOAD_ERR_OK) {
        return file_get_contents($file['tmp_name']);
    }
    return null;
}

$immagine1_content = getFileContent($_FILES['immagine1']);
$immagine2_content = getFileContent($_FILES['immagine2']);
$immagine3_content = getFileContent($_FILES['immagine3']);

// Connessione DB
$conn = new mysqli("localhost", "root", "", "my_enricoghezzo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepara la query con segnaposto per immagini blob
$query = $conn->prepare("INSERT INTO appartamenti
    (proprietario, nome, citta, indirizzo, numero_camere, numero_letti, prezzo, descrizione, numero_persone, immagine1, immagine2, immagine3)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$query->bind_param("ssssiidsibbb",
    $_SESSION["username"], $nome, $citta, $indirizzo,
    $numero_camere, $numero_letti, $prezzo, $descrizione,
    $numero_persone, $null, $null, $null);

// Usa send_long_data per ogni immagine
$query->send_long_data(9, $immagine1_content);
$query->send_long_data(10, $immagine2_content);
$query->send_long_data(11, $immagine3_content);

if ($query->execute()) {
    $apartment_id = $conn->insert_id;

    $stmt_servizi = $conn->prepare("INSERT INTO axs (appartamento, servizio) VALUES (?, ?)");
    $stmt_servizi->bind_param("is", $apartment_id, $servizio);

    foreach ($serviziSelezionati as $serv) {
        $servizio = $serv;
        $stmt_servizi->execute();
    }
    $stmt_servizi->close();

    $query->close();
    $conn->close();

    header("Location: index.php?messaggio=appartamento_creato");
    exit();
} else {
    echo "Errore nell'inserimento dell'appartamento: " . $query->error;
}

$conn->close();
?>
