<?php
require_once('../includes/dbconnection.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$table = $conn->real_escape_string($_GET['table']);
$protocol_nu = $conn->real_escape_string($_GET['protocol_nu']);

$sql = "DELETE FROM $table WHERE protocol_nu = '$protocol_nu'";

if ($conn->query($sql) === TRUE) {
    header("Location: ../details.php?protocol_nu=" . urlencode($protocol_nu));
    exit;
} else {
    echo "Silme işlemi sırasında hata oluştu: " . $conn->error;
}

$conn->close();
?>
