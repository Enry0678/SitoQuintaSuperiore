<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota ora la tua vacanza</title>
    <link rel="stylesheet" href="styles.css">
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

    <div class="hero">
        <h1>Trova l'alloggio che fa per te</h1>
        <p>Cerca offerte su appartamenti privati in tutta Italia</p>
    </div>

    <form action="findApartments.php" method="get">
        <div class="form-row">
            <div class="form-group">
                <label for="city" class="form-label">Città</label>
                <input type="text" id="city" name="city" placeholder="Città" required>
            </div>
            <div class="form-group">
                <label for="checkin" class="form-label">Check-in</label>
                <input type="date" id="checkin" name="checkin" required>
            </div>
            <div class="form-group">
                <label for="checkout" class="form-label">Check-out</label>
                <input type="date" id="checkout" name="checkout" required>
            </div>
            <div class="form-group">
                <label for="adulti" class="form-label">Adulti</label>
                <input type="number" id="adulti" name="adulti" value="1" min="1" required>
            </div>
            <div class="form-group">
                <label for="bambini" class="form-label">Bambini</label>
                <input type="number" id="bambini" name="bambini" value="0" min="0" required>
            </div>
            <div class="form-group">
                <label for="camere" class="form-label">Camere</label>
                <input type="number" id="camere" name="camere" value="1" min="1" required>
            </div>
            <div class="form-group">
                <label for="letti" class="form-label">Letti</label>
                <input type="number" id="letti" name="letti" value="1" min="1" required>
            </div>
            <div class="form-group form-btn-group">
                <button type="submit">Cerca</button>
            </div>
        </div>
    </form>

    <div class="info-box">
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