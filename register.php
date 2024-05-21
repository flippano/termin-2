<?php
$host = 'localhost';
$db = 'termin';
$user = 'root';
$pass = 'Root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    PDO::ATTR_EMULATE_PREPARES => false, 
];

$pdo = new PDO($dsn, $user, $pass, $opt);

//legg til bruker
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);

        header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css"> 
</head>

<body>
    <h2>Registration Form</h2>
    <form id="registrationForm" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br> 

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br> 

        <button type="submit">Register</button> 
        <a href="index.html">cancel</a> 
    </form>
</body>

</html>