<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'booking_db';
$username = 'root';
$password = '';

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Basic validation
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Per favore, compila tutti i campi.";
        header("Location: login.php");
        exit();
    }

    try {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Set remember me cookie if requested
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days

                // Store token in database
                $stmt = $pdo->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
                $stmt->execute(['token' => $token, 'id' => $user['id']]);

                // Set cookie
                setcookie('remember_token', $token, $expiry, '/', '', true, true);
            }

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Username o password non validi.";
            header("Location: login.php");
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Si è verificato un errore. Riprova più tardi.";
        header("Location: login.php");
        exit();
    }
} else {
    // If someone tries to access this file directly
    header("Location: login.php");
    exit();
}
?> 