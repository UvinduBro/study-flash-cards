<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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

// Handle form submission to add flashcard
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $user_id = $_SESSION['user_id'];

    if (!empty($question) && !empty($answer)) {
        $sql = "INSERT INTO flashcards (question, answer, user_id) VALUES ('$question', '$answer', '$user_id')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
            exit;
        } else {
            die('Error adding flashcard: ' . mysqli_error($conn));
        }
    }
}

// Query flashcards for the logged in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM flashcards WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$flashcards = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Flashcard Generator</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Flashcard Generator</h1>
        <form method="post" action="index.php">
            <input type="text" name="question" placeholder="Enter a question">
            <input type="text" name="answer" placeholder="Enter an answer">
            <button type="submit">Add Flashcard</button>
        </form>
        <div id="flashcardContainer">
            <?php foreach ($flashcards as $flashcard) { ?>
                <div class="flashcard">
                    <div class="question"><?php echo $flashcard['question']; ?></div>
                    <div class="answer"><?php echo $flashcard['answer']; ?></div>
                </div>
            <?php } ?>
        </div>
        <a href="logout.php">Log out</a>
    </div>
</body>
</html>
