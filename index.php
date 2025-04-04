<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>

    <body style="background-color:BlanchedAlmond">
        <h1>Prenotazione di appartamenti</h1>
        <form action="#" method="get">
            <input type="text" id="citta" name="citta" placeholder="citta">
            <label for="data_inizio">DA</label>
            <input type="date" id="data_inizio" name="data_inizio">
            <label for="data_fine">A</label>
            <input type="date" id="data_fine" name="data_fine">
            <input type="number" id="adulti" name="adulti" placeholder="adulti">
            <input type="number" id="bambini" name="bambini" placeholder="bambini">
            <input type="submit" value="CERCA">
        </form>
    </body>
</html>