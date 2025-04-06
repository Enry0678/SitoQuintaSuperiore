<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="container">
            <div class="form-header">
                <h1>Prenotazione di appartamenti</h1>
                <p>Trova l'alloggio perfetto per il tuo soggiorno</p>
            </div>
            <form action="#" method="get">
                <div class="form-group">
                    <label for="citta">Città</label>
                    <div class="input-icon">
                        <i class="fas fa-city"></i>
                        <input type="text" id="citta" name="citta" placeholder="Inserisci la città">
                    </div>
                </div>
                
                <div class="date-group">
                    <div class="date-input">
                        <label for="data_inizio">Data di arrivo</label>
                        <div class="input-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" id="data_inizio" name="data_inizio">
                        </div>
                        <div id="calendar-start" class="calendar-container"></div>
                    </div>
                    <div class="date-input">
                        <label for="data_fine">Data di partenza</label>
                        <div class="input-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" id="data_fine" name="data_fine">
                        </div>
                        <div id="calendar-end" class="calendar-container"></div>
                    </div>
                </div>
                
                <div class="people-group">
                    <div class="people-input">
                        <label for="adulti">Adulti</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="number" id="adulti" name="adulti" placeholder="Numero di adulti" min="1">
                        </div>
                    </div>
                    <div class="people-input">
                        <label for="bambini">Bambini</label>
                        <div class="input-icon">
                            <i class="fas fa-child"></i>
                            <input type="number" id="bambini" name="bambini" placeholder="Numero di bambini" min="0">
                        </div>
                    </div>
                </div>
                
                <input type="submit" value="Cerca alloggi">
            </form>
        </div>
        
        <script src="calendar.js"></script>

        <div class="container description-section">
            <h2>Il Tuo Soggiorno Perfetto in Italia</h2>
            <p>Benvenuti nella vostra destinazione ideale per trovare l'alloggio perfetto in Italia. La nostra piattaforma vi offre un'ampia selezione di appartamenti e sistemazioni in tutta la penisola, dalle vivaci città d'arte alle tranquille località costiere.</p>
            
            <div class="features">
                <div class="feature">
                    <h3><i class="fas fa-map-marker-alt"></i> Posizioni Strategiche</h3>
                    <p>Appartamenti selezionati in location privilegiate, vicino ai principali punti d'interesse e ben collegati con i mezzi pubblici.</p>
                </div>
                
                <div class="feature">
                    <h3><i class="fas fa-home"></i> Comfort e Qualità</h3>
                    <p>Alloggi accuratamente verificati che garantiscono tutti i comfort necessari per un soggiorno indimenticabile.</p>
                </div>
                
                <div class="feature">
                    <h3><i class="fas fa-euro-sign"></i> Prezzi Trasparenti</h3>
                    <p>Tariffe competitive e nessun costo nascosto, per permettervi di pianificare il vostro budget in totale serenità.</p>
                </div>
            </div>
            
            <p class="closing-text">Che stiate pianificando una vacanza in famiglia, un viaggio di lavoro o una fuga romantica, abbiamo l'alloggio perfetto per le vostre esigenze. Iniziate ora la vostra ricerca e scoprite il meglio dell'ospitalità italiana.</p>
        </div>
    </body>
</html>