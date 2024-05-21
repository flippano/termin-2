<?php
session_start();

$db = new mysqli('localhost', 'root', 'Root', 'termin');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_admin'] = (bool) $user['isadmin'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid username or password";
    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css"> 
</head>

<body>
    <h2>Login Form</h2>
    <?php if (isset($error_message)): ?> 
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form id="loginForm" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br> 

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br> 

        <button type="submit">Login</button> 
        <a href="index.html">cancel</a> 
    </form>
</body>

</html>