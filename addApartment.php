<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi un appartamento</title>
</head>
<body>
    <header>
        <nav>
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
        </nav>
    </header>
    
    <h1>Crea un appartamento</h1>
    <form action="registerApartment.php" method="get">
            <!-- inserisci il form per aggiungere un appartamento al sito -->
             <label for="nome">Nome:</label><br>
             <input type="text" name="nome" id="nome" placeholder="nome dell'appartamento" size="100"><br>
             
             <label for="citta">Città:</label>
             <select name="citta" id="citta">
                <?php
                    // Connessione al database
                    $nomeDatabase = "appartamentiDB";
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
            </select><br>

            <label for="indirizzo">Indirizzo:</label><br>
            <input type="text" name="indirizzo" id="indirizzo" size="100"><br>

            <label for="numero_camere">Numero di camere:</label><br>
            <input type="number" name="numero_camere" id="numero_camere"><br>

            <label for="numero_letti">Numeri di letti:</label><br>
            <input type="number" name="numero_letti" id="numero_letti"><br>

            <label for="posti_letto">Posti letto:</label><br>
            <input type="number" name="posti_letto" id="posti_letto"><br>

            <label for="prezzo">Prezzo per persona:</label><br>
            <input type="number" name="prezzo" id="prezzo"><br>

            <label for="descrizione">Descrizione:</label><br>
            <input type="text" name="descrizione" id="descrizione" size="500"><br>

            <label for="servizi">Seleziona i servizi disponibili nell'appartamento:</label><br>
            
            <?php

                // Query per ottenere i dati
                $mysqli = $conn->prepare("SELECT * FROM servizi");
                $mysqli->execute();
                $result = $mysqli->get_result();
                
                $index = 0;
                while($row = $result->fetch_assoc()){
                    echo "<input type='checkbox' name='serv{$index}' id='serv{$index}' value='{$row["nome"]}'>";
                    echo "<label for='serv{$index}'>{$row["nome"]} {$row["simbolo"]}</label><br>";
                }

            ?>

            <input type="submit" value="Crea appartamento">
    </form>

</body>
</html>