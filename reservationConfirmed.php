<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione Confermata</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .centered-form-container {
            margin-top: 10px;
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

        h2 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
        }

        .btn-primary {
            width: auto;
            min-width: 200px;
            margin: 0 auto;
        }

        .success-message {
            text-align: center;
            color: #059669;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
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
            <div class="success-message">
                <h2>Prenotazione Confermata!</h2>
                <p>La tua prenotazione è stata effettuata con successo.</p>
            </div>
            <div style="text-align:center; margin-top:2rem;">
                <p style="margin-bottom: 1rem;">
                    <a href="PDFPrenotazione.php" style="color: #2563c7; text-decoration: underline;">Scarica il PDF con i dettagli della prenotazione</a>
                </p>
                <a href="index.php">
                    <button class="btn-primary">Torna alla Home</button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>