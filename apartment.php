<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appartamento</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .apartment-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .apartment-header {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            border: 2px solid #febb02;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .apartment-title {
            color: #003580;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .apartment-info {
            color: #2563c7;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .apartment-price {
            font-size: 1.3rem;
            font-weight: 600;
            color: #28a745;
            margin: 1rem 0;
        }

        .apartment-description {
            margin: 1.5rem 0;
            line-height: 1.6;
            color: #444;
        }

        .apartment-images {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .apartment-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .services-section {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            border: 2px solid #febb02;
            padding: 2rem;
            margin: 2rem 0;
        }

        .services-title {
            color: #003580;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .services-list {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .service-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #2563c7;
            font-size: 1.1rem;
        }

        .booking-section {
            text-align: center;
            margin: 2rem 0;
        }

        .btn-book {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-book:hover {
            background-color: #218838;
        }

        .unavailable-message {
            color: #dc3545;
            font-size: 1.2rem;
            font-weight: 500;
            text-align: center;
            margin: 2rem 0;
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

    <div class="apartment-container">
        <?php
        $codice = $_GET["codice"];
        $checkin = isset($_GET["checkin"]) ? $_GET["checkin"] : null;
        $checkout = isset($_GET["checkout"]) ? $_GET["checkout"] : null;
        $adulti = isset($_GET["adulti"]) ? (int)$_GET["adulti"] : 1;
        $bambini = isset($_GET["bambini"]) ? (int)$_GET["bambini"] : 0;

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

        if ($checkin && $checkout) {
            $date1 = DateTime::createFromFormat('Y-m-d', $checkin);
            $date2 = DateTime::createFromFormat('Y-m-d', $checkout);
            if ($date1 && $date2) {
                $diff = $date2->diff($date1)->days;
                $giorni = ($diff > 0) ? $diff : 1;
            } else {
                $giorni = 1;
            }
        } else {
            $giorni = 1;
        }

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<div class='apartment-header'>";
                echo "<h1 class='apartment-title'>" . htmlspecialchars($row["nome"]) . "</h1>";
                
                $stmt = $conn->prepare("SELECT * FROM utenti WHERE username = ?");
                $stmt->bind_param("s", $row['proprietario']);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $row1 = $result1->fetch_assoc();

                echo "<div class='apartment-info'>";
                echo "<p><strong>Proprietario:</strong> " . htmlspecialchars($row["proprietario"]) . "</p>";
                echo "<p><strong>Contatto:</strong> " . htmlspecialchars($row1['telefono']) . "</p>";
                echo "<p><strong>Indirizzo:</strong> " . htmlspecialchars($row["indirizzo"]) . "</p>";
                echo "<p><strong>Città:</strong> " . htmlspecialchars($row["citta"]) . "</p>";
                echo "<p><strong>Camere:</strong> " . htmlspecialchars($row["numero_camere"]) . "</p>";
                echo "<p><strong>Letti:</strong> " . htmlspecialchars($row["numero_letti"]) . "</p>";
                echo "<p><strong>Posti letto:</strong> " . htmlspecialchars($row["numero_persone"]) . "</p>";
                echo "</div>";

                echo "<div class='apartment-price'>";
                echo "Prezzo totale: " . $row["prezzo"]*$giorni*($adulti+$bambini) . "€";
                echo "</div>";

                echo "<div class='apartment-description'>";
                echo "<p>" . nl2br(htmlspecialchars($row["descrizione"])) . "</p>";
                echo "</div>";
                echo "</div>";

                echo "<div class='apartment-images'>";
                $tipo_mime = 'image/jpeg';
                if ($row["immagine1"] !== "") {
                    $base64_immagine = base64_encode($row["immagine1"]);
                    echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' class='apartment-image' alt='Immagine appartamento 1'>";
                }
                if ($row["immagine2"] !== "") {
                    $base64_immagine = base64_encode($row["immagine2"]);
                    echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' class='apartment-image' alt='Immagine appartamento 2'>";
                }
                if ($row["immagine3"] !== "") {
                    $base64_immagine = base64_encode($row["immagine3"]);
                    echo "<img src='data:" . $tipo_mime . ";base64," . $base64_immagine . "' class='apartment-image' alt='Immagine appartamento 3'>";
                }
                echo "</div>";

                echo "<div class='services-section'>";
                echo "<h3 class='services-title'>Servizi inclusi</h3>";
                $queryServizi = $conn->prepare("SELECT nome, simbolo FROM servizi INNER JOIN axs ON servizi.nome=axs.servizio WHERE axs.appartamento = ?");
                $queryServizi->bind_param("s", $codice);
                $queryServizi->execute();
                $resultServizi = $queryServizi->get_result();

                if ($resultServizi->num_rows > 0) {
                    echo "<ul class='services-list'>";
                    while ($rowServizio = $resultServizi->fetch_assoc()) {
                        echo "<li class='service-item'>";
                        echo "<span>{$rowServizio["simbolo"]}</span>";
                        echo "<span>" . htmlspecialchars($rowServizio["nome"]) . "</span>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Nessun servizio disponibile per questo appartamento.</p>";
                }
                echo "</div>";
                $queryServizi->close();
            }
        }

        $stmt = $conn->prepare("
            SELECT *
            FROM prenotazioni
            WHERE appartamento = ?
            AND (
                (data_inizio < ? AND data_fine > ?)
                OR
                (data_inizio <= ? AND data_fine >= ? AND NOT (data_inizio < ? AND data_fine > ?))
                OR
                (data_fine BETWEEN ? AND ?)
                OR
                (data_inizio BETWEEN ? AND ?)
                OR
                ((data_inizio BETWEEN ? AND ?) AND (data_fine BETWEEN ? AND ?))
            );
        ");
        $stmt->bind_param("sssssssssssssss", $codice,
            $checkin, $checkout,
            $checkin, $checkout, $checkin, $checkout,
            $checkin, $checkout,
            $checkin, $checkout,
            $checkin, $checkout, $checkin, $checkout
        );
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='booking-section'>";
        if($result->num_rows == 0){
            echo "<a href='reservation.php?codice={$codice}&checkin={$checkin}&checkout={$checkout}&adulti={$adulti}&bambini={$bambini}' class='btn-book'>Prenota ora</a>";
        } else {
            echo "<p class='unavailable-message'>L'appartamento è già stato prenotato per queste date</p>";
        }
        echo "</div>";
        ?>
    </div>
</body>
</html>