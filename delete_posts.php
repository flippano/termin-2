<?php
$servername = "localhost";
$username = "root";
$password = "Root";
$dbname = "termin";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "DELETE FROM posts";

if ($conn->query($sql) === TRUE) {
    echo "Records deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
