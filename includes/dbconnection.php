<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    exit("Bu sayfaya doğrudan erişim izni yok.");
}

$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Veritabanına bağlanılamadı: " . $conn->connect_error);
}

?>
