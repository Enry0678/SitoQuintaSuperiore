<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica account</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
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
        <form action="applyChangesProfile.php" method="post" class="auth-form" id="modifyForm">
            <h2>Modifica Profilo</h2>
            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" placeholder="nuova password"><br>
                <input type="password" name="password_check" id="password_check" placeholder="conferma nuova password"><br>
                <div id="password-message"></div>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" placeholder="nuova email">
            </div>
            
            <div class="form-group">
                <label for="telefono" class="form-label">Telefono:</label>
                <input type="tel" name="telefono" id="telefono">
            </div>
            
            <div class="form-actions" style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
                <input type="submit" value="Conferma le modifiche" class="btn-primary">
                <a href="account.php" class="btn-primary">Annulla</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('modifyForm');
            const password = document.getElementById('password');
            const passwordCheck = document.getElementById('password_check');
            const passwordMessage = document.getElementById('password-message');
            const submitButton = form.querySelector('input[type="submit"]');

            function checkPasswords() {
                if (password.value === '' && passwordCheck.value === '') {
                    passwordMessage.innerHTML = '';
                    submitButton.disabled = false;
                    return;
                }

                if (password.value !== passwordCheck.value) {
                    passwordMessage.innerHTML = 'Le password non coincidono';
                    passwordMessage.className = 'error-message';
                    submitButton.disabled = true;
                } else {
                    passwordMessage.innerHTML = 'Le password coincidono';
                    passwordMessage.className = 'success-message';
                    submitButton.disabled = false;
                }
            }

            password.addEventListener('input', checkPasswords);
            passwordCheck.addEventListener('input', checkPasswords);

            form.addEventListener('submit', function(e) {
                if (password.value !== passwordCheck.value) {
                    e.preventDefault();
                    passwordMessage.innerHTML = 'Le password non coincidono';
                    passwordMessage.className = 'error-message';
                }
            });
        });
    </script>
</body>
</html>