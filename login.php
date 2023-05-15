<?php
session_start();

// Redirect to index.php if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Connect to MySQL database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'flashcards';
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die('Error connecting to database: ' . mysqli_connect_error());
}

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Login successful, store the user ID in session
            $_SESSION['user_id'] = $user['id'];

            // Redirect to index.php
            header('Location: index.php');
            exit;
        }
    }

    // If login fails, show an error message
    $error = 'Invalid username or password.';
}

// Close database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="login.php">
            <?php if (isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
