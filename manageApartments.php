<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestisci i tuoi appartamenti</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .apartment-list {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .apartment-item {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            border: 2px solid #febb02;
            padding: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }

        .apartment-item:hover {
            transform: translateY(-3px);
        }

        .apartment-name {
            color: #003580;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
        }

        .apartment-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-view {
            background-color: #0071c2;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }

        .btn-view:hover {
            background-color: #005fa3;
        }

        .no-apartments {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin: 2rem 0;
        }

        .add-apartment-section {
            text-align: center;
            margin: 3rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.2s;
            width: auto;
            min-width: 200px;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .page-title {
            text-align: center;
            color: #003580;
            margin: 2rem 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .section-title {
            color: #003580;
            margin: 2rem 0 2rem 0;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
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

    <h1 class="page-title">Gestisci i tuoi appartamenti</h1>

    <div class="apartment-list">
        <?php
        // Connessione al database
        $nomeDatabase = "my_enricoghezzo";
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

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='apartment-item'>";
                echo "<a href='apartment.php?codice={$row['codice']}' class='apartment-name'>" . htmlspecialchars($row['nome']) . "</a>";
                echo "<div class='apartment-actions'>";
                echo "<a href='viewReservations.php?codice={$row['codice']}' class='btn-view'>Visualizza prenotazioni</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-apartments'>Non hai ancora registrato un appartamento</p>";
        }

        echo "<div class='add-apartment-section'>";
        echo "<h2 class='section-title'>Aggiungi un appartamento</h2>";
        echo "<form action='addApartmentForm.php' method='get'>";
        echo "<input type='submit' value='Aggiungi un appartamento' class='btn-add'>";
        echo "</form>";
        echo "</div>";

        $mysqli->close();
        $conn->close();
        ?>
    </div>
</body>
</html>