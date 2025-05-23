<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi un appartamento</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="navbar-container">
                <a href="index.php" class="site-name">ItaliaStay</a>
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
        <form action="addApartment.php" method="post" enctype="multipart/form-data" class="profile-card">
            <div class="profile-info">
                <h2>Crea un appartamento</h2>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="nome dell'appartamento" required>
                    <label for="citta">Città:</label>
                    <select name="citta" id="citta" required>
                        <?php
                            // Connessione al database
                            $nomeDatabase = "my_enricoghezzo";
                            $nomeUtenteDB = "root";
                            $passwordDB = "";

                            $conn = new mysqli("localhost", $nomeUtenteDB, $passwordDB, $nomeDatabase);
                            if($conn->connect_error){
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Query per ottenere i dati
                            $mysqli = $conn->prepare("SELECT nome FROM citta");
                            $mysqli->execute();
                            $result = $mysqli->get_result();

                            while($row = $result->fetch_assoc()){
                                echo "<option value='{$row["nome"]}'> {$row["nome"]} ";
                            }
                        ?>
                    </select>
                <label for="indirizzo">Indirizzo:</label>
                <input type="text" name="indirizzo" id="indirizzo" required>

                <label for="numero_camere">Numero di camere:</label>
                <input type="number" name="numero_camere" id="numero_camere" required>

                <label for="numero_letti">Numeri di letti:</label>
                <input type="number" name="numero_letti" id="numero_letti" required>

                <label for="posti_letto">Posti letto:</label>
                <input type="number" name="posti_letto" id="posti_letto" required>

                <label for="prezzo">Prezzo per persona:</label>
                <input type="number" name="prezzo" id="prezzo" required>

                <label for="descrizione">Descrizione:</label>
                <input type="text" name="descrizione" id="descrizione" required>

                <label for="servizi">Seleziona i servizi disponibili nell'appartamento:</label>
                <div class="services-container">
                    <?php
                        // Query per ottenere i dati
                        $mysqli = $conn->prepare("SELECT * FROM servizi");
                        $mysqli->execute();
                        $result = $mysqli->get_result();

                        while($row = $result->fetch_assoc()){
                            echo "<label class='service-item'>";
                            echo "<input type='checkbox' name='servizi[]' value='{$row["nome"]}' id='servizio_{$row["nome"]}'>";
                            echo "<span>{$row["nome"]} {$row["simbolo"]}</span>";
                            echo "</label>";
                        }
                    ?>
                </div>

                <label for="immagine1">Immagine 1:</label>
                <input type="file" name="immagine1" id="immagine1" required>

                <label for="immagine2">Immagine 2:</label>
                <input type="file" name="immagine2" id="immagine2">

                <label for="immagine3">Immagine 3:</label>
                <input type="file" name="immagine3" id="immagine3">

                <input type="submit" value="Crea appartamento" class="btn-primary">
            </div>
        </form>
    </div>
</body>
</html>