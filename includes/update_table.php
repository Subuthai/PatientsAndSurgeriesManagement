<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'], $_POST['protocol_nu'], $_POST['patient_nu'])) {
        require_once('dbconnection.php');

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        $table = $_POST['table'];
        $protocol_nu = $conn->real_escape_string($_POST['protocol_nu']);
        $patient_nu = $conn->real_escape_string($_POST['patient_nu']); 

        $update_values = [];
        foreach ($_POST as $column => $value) {
            if ($column != 'table' && $column != 'protocol_nu' && $column != 'patient_nu') { 
                $update_values[] = "$column = '" . $conn->real_escape_string($value) . "'";
            }
        }

        $sql = "UPDATE $table SET " . implode(", ", $update_values) . " WHERE protocol_nu = '$protocol_nu'";

        if ($conn->query($sql) === TRUE) {
            $redirect_url = "../details.php?protocol_nu=" . urlencode($protocol_nu);
            header("Location: $redirect_url");
            exit;
        } else {
            echo "Güncelleme işlemi sırasında hata oluştu: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Gerekli parametreler eksik:";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
} else {
    echo "Bu sayfaya doğrudan erişim izni yok.";
}
?>
