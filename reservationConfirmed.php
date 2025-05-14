<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione confermata</title>
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
?>

<h1>La tua prenotazione è stata confermata</h1>

Scarica il pdf con i dati della tua prenotazione <a href="PDFPrenotazione.php">qui</a><br>

<button type="submit" onclick="window.location.href='index.php';">Torna alla home</button>
</body>
</html>