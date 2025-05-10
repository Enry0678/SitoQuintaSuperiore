<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota ora</title>
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

    <h1>Prenota ora</h1>
    <h2>Controlla che i dati della prenotazione siano corretti</h2>

    <?php
    $adulti = $_GET["adulti"];
    $bambini = $_GET["bambini"];
    $checkin = date_format(date_create($_GET["checkin"]), "d/m/Y");
    $checkout = date_format(date_create($_GET["checkout"]), "d/m/Y");
    $checkinDB = $_GET["checkin"];
    $checkoutDB = $_GET["checkout"];
    $codice = $_GET["codice"];

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
    $result = $result->fetch_assoc();

    echo "Utente che effettua la prenotazione: {$_SESSION['username']} <br>";
    echo "Appartamento selezionato: {$result['nome']} <br>";
    echo "Numero di adulti: {$adulti} <br>";
    echo "Numero di bambini: {$bambini} <br>";
    echo "Data di checkin: {$checkin} <br>";
    echo "Data di checkout {$checkout} <br>";

    echo "<h3>Se i tuoi dati sono corretti prenota ora<h3>";
    echo "<form action='makeReservation.php?codice={$codice}&utente={$_SESSION['username']}&adulti={$adulti}&bambini={$bambini}&data_inizio={$checkinDB}&data_fine={$checkoutDB}' method='get'>";
    echo "    <input type='submit' value='Prenota'>";
    echo "</form>";
    ?>
</body>
</html>