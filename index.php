<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota ora la tua vacanza</title>
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

    <form action="findApartments.php" method="get">
        <label for="city">Città:</label>
        <input type="text" id="city" name="city" required>
        <label for="checkin">Data di check-in:</label>
        <input type="date" id="checkin" name="checkin" required>
        <label for="checkout">Data di check-out:</label>
        <input type="date" id="checkout" name="checkout" required>
        <button type="submit">Cerca</button>
    </form>

    <div>
        <p>Scopri il modo più autentico di vivere l'Italia attraverso soggiorni in appartamenti privati selezionati.</p>
        
        <p>La nostra piattaforma ti permette di esplorare una vasta selezione di appartamenti in tutta Italia, 
        dalle pittoresche città d'arte alle incantevoli località costiere, dalle tranquille campagne toscane 
        alle vivaci metropoli.</p>

        <p>Ogni appartamento è messo a disposizione da proprietari privati che aprono le porte delle loro case, 
        offrendoti un'esperienza di soggiorno autentica e personale. Che tu stia cercando un accogliente 
        monolocale nel cuore di Roma, un appartamento vista mare in Costiera Amalfitana o un rustico 
        tra le colline umbre, troverai la sistemazione perfetta per le tue esigenze.</p>

        <p>Inizia ora la tua ricerca e vivi un'esperienza di viaggio unica nel Bel Paese!</p>
    </div>
</body>
</html>