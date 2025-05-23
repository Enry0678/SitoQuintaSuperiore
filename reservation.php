<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota ora</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .centered-form-container {
            margin-top: 80px;
            padding: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .profile-card {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            width: 100%;
            box-sizing: border-box;
        }

        form label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        form input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        form input:focus {
            outline: none;
            border-color: #2563c7;
            box-shadow: 0 0 0 2px #eaf1fb;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
        }

        .profile-info p {
            margin: 0.5rem 0;
            line-height: 1.5;
        }

        .btn-primary {
            width: auto;
            min-width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="navbar-container">
                <div class="site-name">ItaliaStay</div>
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
            </div>
        </nav>
    </header>

    <div class="centered-form-container">
        <div class="profile-card">
            <h2>Dettagli Prenotazione</h2>
            <div class="profile-info">
                <?php
                if(!isset($_SESSION["username"])){
                    header("Location: login.php");
                    exit();
                }


                $adulti = $_GET["adulti"];
                $bambini = $_GET["bambini"];
                $checkin = date_format(date_create($_GET["checkin"]), "d/m/Y");
                $checkout = date_format(date_create($_GET["checkout"]), "d/m/Y");
                $checkinDB = $_GET["checkin"];
                $checkoutDB = $_GET["checkout"];
                $codice = $_GET["codice"];

                $nomeDatabase = "my_enricoghezzo";
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

                echo "<p><strong>Utente:</strong> {$_SESSION['username']}</p>";
                echo "<p><strong>Appartamento:</strong> {$result['nome']}</p>";
                echo "<p><strong>Adulti:</strong> {$adulti}</p>";
                echo "<p><strong>Bambini:</strong> {$bambini}</p>";
                echo "<p><strong>Check-in:</strong> {$checkin}</p>";
                echo "<p><strong>Check-out:</strong> {$checkout}</p>";

                $conn->close();
                ?>
            </div>
        </div>

        <form action="#" method="post">
            <h2>Pagamento</h2>
            <label for="cardholder"><strong>Intestatario carta:</strong></label>
            <input type="text" id="cardholder" name="cardholder" placeholder="Mario Rossi" required>

            <label for="cardnumber"><strong>Numero carta:</strong></label>
            <input type="text" id="cardnumber" name="cardnumber" placeholder="1234 5678 9012 3456" pattern="[0-9\s]{13,19}" maxlength="19" required>

            <label for="expiry"><strong>Data di scadenza (MM/AA):</strong></label>
            <input type="text" id="expiry" name="expiry" placeholder="MM/AA" pattern="(0[1-9]|1[0-2])\/\d{2}" maxlength="5" required>

            <label for="cvv"><strong>CVV:</strong></label>
            <input type="text" id="cvv" name="cvv" placeholder="123" pattern="\d{3}" maxlength="3" required>

            <div style="text-align:center; margin:1.2rem 0;">
                <a href="makeReservation.php?codice=<?php echo $codice; ?>&utente=<?php echo $_SESSION['username']; ?>&adulti=<?php echo $adulti; ?>&bambini=<?php echo $bambini; ?>&data_inizio=<?php echo $checkinDB; ?>&data_fine=<?php echo $checkoutDB; ?>">
                    <button type="button" class="btn-primary">Conferma Prenotazione</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>