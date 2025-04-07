<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <div class="header-content">
            <div class="header-left">
                <a href="index.php" class="logo">B</a>
                <button class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <a href="login.php" class="login-btn active">Login</a>
                <a href="signup.php" class="signup-btn">Sign up</a>
            </div>
        </div>
    </header>

    <main class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>Accedi</h1>
                <p>Benvenuto! Accedi al tuo account per continuare.</p>
            </div>
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <form class="login-form" action="process_login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username o Email</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" required placeholder="Inserisci il tuo username o email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="Inserisci la tua password">
                    </div>
                </div>
                <button type="submit" class="login-submit">Accedi</button>
            </form>
            <div class="login-footer">
                <p>Non hai un account? <a href="signup.php">Registrati</a></p>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mainNav = document.querySelector('.main-nav');
            const authButtons = document.querySelector('.auth-buttons');

            mobileMenuToggle.addEventListener('click', function() {
                mainNav.classList.toggle('active');
                authButtons.classList.toggle('active');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.site-header')) {
                    mainNav.classList.remove('active');
                    authButtons.classList.remove('active');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    mainNav.classList.remove('active');
                    authButtons.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html> 