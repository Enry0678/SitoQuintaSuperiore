<?php
session_start();
require('fpdf186/fpdf.php');

$utente = $_SESSION['username'];

// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'my_enricoghezzo');
if ($conn->connect_error) die("Connessione fallita: " . $conn->connect_error);

// Ultima prenotazione
$sqlPrenotazione = "SELECT * FROM prenotazioni WHERE utente = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sqlPrenotazione);
$stmt->bind_param("s", $utente);
$stmt->execute();
$resultPrenotazione = $stmt->get_result();
if ($resultPrenotazione->num_rows === 0) die("Nessuna prenotazione trovata per l'utente.");
$prenotazione = $resultPrenotazione->fetch_assoc();

// Calcoli base
$numero_persone = $prenotazione['adulti'] + $prenotazione['bambini'];
$data_inizio = new DateTime($prenotazione['data_inizio']);
$data_fine = new DateTime($prenotazione['data_fine']);
$giorni = $data_inizio->diff($data_fine)->days;
if ($giorni == 0) $giorni = 1;

// Info appartamento
if(isset($_GET['codice'])){
    $cod = $_GET['codice'];
    $sqlAppartamento = "SELECT * FROM appartamenti WHERE codice = ?";
    $stmt = $conn->prepare($sqlAppartamento);
    $stmt->bind_param("i", $cod);
    $stmt->execute();
    $resultAppartamento = $stmt->get_result();
    if ($resultAppartamento->num_rows === 0) die("Appartamento non trovato.");
    $appartamento = $resultAppartamento->fetch_assoc();
}
else{
    $sqlAppartamento = "SELECT * FROM appartamenti WHERE codice = ?";
    $stmt = $conn->prepare($sqlAppartamento);
    $stmt->bind_param("i", $prenotazione['appartamento']);
    $stmt->execute();
    $resultAppartamento = $stmt->get_result();
    if ($resultAppartamento->num_rows === 0) die("Appartamento non trovato.");
    $appartamento = $resultAppartamento->fetch_assoc();
}

// Prezzo totale
$prezzo_unitario = $appartamento['prezzo'];
$prezzo_totale = $numero_persone * $giorni * $prezzo_unitario;

// Creazione PDF
$pdf = new FPDF();
$pdf->AddPage();

// Titolo
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(30, 30, 120);
$pdf->Cell(0, 12, utf8_decode('Dettaglio Prenotazione'), 0, 1, 'C');
$pdf->Ln(6);

// Dati appartamento
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetTextColor(0);
$pdf->Cell(0, 10, utf8_decode("Dati Appartamento:"), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, utf8_decode("Nome: " . $appartamento['nome']), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Città: " . $appartamento['citta']), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Indirizzo: " . $appartamento['indirizzo']), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Proprietario: " . $appartamento['proprietario']), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Camere: " . $appartamento['numero_camere'] . " - Letti: " . $appartamento['numero_letti']), 0, 1);
$pdf->Ln(4);

// Dettagli prenotazione
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, utf8_decode("Dettagli Prenotazione:"), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, utf8_decode("Date: " . $data_inizio->format('d/m/Y') . " - " . $data_fine->format('d/m/Y')), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Numero Persone: " . $numero_persone), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Prezzo per persona/giorno: EUR " . number_format($prezzo_unitario, 2)), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Durata: $giorni giorni"), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode("Totale: EUR " . number_format($prezzo_totale, 2)), 0, 1);
$pdf->Ln(5);

// Descrizione
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, utf8_decode("Descrizione:"), 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 8, utf8_decode($appartamento['descrizione']));

$conn->close();
$pdf->Output('I', 'dettagli_prenotazione.pdf');
?>
