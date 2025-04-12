<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <form action="validateRegister.php" method="post" id="registrationForm">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br>

        <label for="cognome">Cognome:</label><br>
        <input type="text" id="cognome" name="cognome" required><br>

        <label for="data_nascita">Data di nascita:</label><br>
        <input type="date" id="data_nascita" name="data_nascita" required><br>

        <label for="nazionalita">Nazionalità:</label><br>
        <select id="nazionalita" name="nazionalita" required>
            <option value="">Seleziona nazionalità</option>
            <option value="IT">Italiano</option>
            <option value="FR">Français</option>
            <option value="DE">Deutsch</option>
            <option value="ES">Español</option>
            <option value="UK">English</option>
            <option value="US">American</option>
            <option value="CH">Schweizer</option>
            <option value="AT">Österreichisch</option>
            <option value="BE">Belge</option>
            <option value="NL">Nederlands</option>
            <option value="PT">Português</option>
            <option value="GR">Ελληνικά</option>
            <option value="PL">Polski</option>
            <option value="RU">Русский</option>
            <option value="CN">中文</option>
            <option value="JP">日本語</option>
            <option value="KR">한국어</option>
            <option value="IN">भारतीय</option>
            <option value="BR">Brasileiro</option>
            <option value="AR">عربي</option>
            <option value="TR">Türkçe</option>
            <option value="SE">Svenska</option>
            <option value="NO">Norsk</option>
            <option value="DK">Dansk</option>
            <option value="FI">Suomalainen</option>
            <option value="CZ">Čeština</option>
            <option value="HU">Magyar</option>
            <option value="RO">Română</option>
            <option value="Other">Altro</option>
        </select><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required>
        <div id="username-message"></div><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Conferma Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="telefono">Telefono:</label><br>
        <input type="tel" id="telefono" name="telefono" required><br>

        <button type="submit" id="submit-btn">Registrati</button>
        
    </form>

    <p>Hai già un account? <a href="login.php">Accedi</a></p>
    <?php
        if(isset($_SESSION["error"])){
            echo "<p style='color: red;'>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]);
        }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const usernameMessage = document.getElementById('username-message');
            const registrationForm = document.getElementById('registrationForm');
            const submitButton = document.getElementById('submit-btn');
            let usernameExists = false;
            let typingTimer;
            const doneTypingInterval = 500; // ms

            // Add event listener to username input
            usernameInput.addEventListener('input', function() {
                clearTimeout(typingTimer);
                
                // Show loading message
                usernameMessage.innerHTML = 'Verifica in corso...';
                usernameMessage.className = '';
                
                // Set a timeout to check after user stops typing
                typingTimer = setTimeout(checkUsername, doneTypingInterval);
            });

            // Function to check username availability
            function checkUsername() {
                const username = usernameInput.value.trim();
                
                if (username === '') {
                    usernameMessage.innerHTML = '';
                    return;
                }
                
                // Create form data
                const formData = new FormData();
                formData.append('username', username);
                
                // Send AJAX request
                fetch('check_username.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        usernameMessage.innerHTML = data.message;
                        usernameMessage.className = 'error-message';
                        usernameExists = true;
                        submitButton.disabled = true;
                    } else {
                        usernameMessage.innerHTML = data.message;
                        usernameMessage.className = 'success-message';
                        usernameExists = false;
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    usernameMessage.innerHTML = 'Errore durante la verifica';
                    usernameMessage.className = 'error-message';
                });
            }

            // Prevent form submission if username exists
            registrationForm.addEventListener('submit', function(event) {
                if (usernameExists) {
                    event.preventDefault();
                    alert('Username già in uso. Scegli un altro username.');
                }
            });
        });
    </script>
</body>
</html>