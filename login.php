<?php
// Start the session
session_start();

// Connect to the database
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debug: print out the value of $user['isadmin']
    var_dump($user['isadmin']);

    // Check if password is correct
    if (password_verify($password, $user['password'])) {
        // Set user_id and is_admin session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['isadmin'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid username or password";
    }
}

// Rest of your code...


?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS stylesheet -->
</head>

<body>
    <h2>Login Form</h2>
    <?php if (isset($error_message)): ?> <!-- If there is an error message, display it -->
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form id="loginForm" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br> <!-- Input for the username -->

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br> <!-- Input for the password -->

        <button type="submit">Login</button> <!-- Button to submit the form and log in -->
        <a href="index.html">cancel</a> <!-- Link to cancel login and return to the index page -->
    </form>
</body>

</html>