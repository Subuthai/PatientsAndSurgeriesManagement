<?php
require_once 'dbconnection.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    exit("Bu sayfaya doğrudan erişim izni yok.");
}

$name_surname = $_POST['name_surname'];
$protocol_nu = $_POST['protocol_nu'];
$patient_nu = $_POST['patient_nu'];
$surgery_name = $_POST['surgery_name'];
$surgery_date = $_POST['surgery_date'];

$sql_patients = "INSERT INTO patients (name_surname, protocol_nu, patient_nu, surgery_name, surgery_date) 
                 VALUES ('$name_surname', '$protocol_nu', '$patient_nu', '$surgery_name', '$surgery_date')";

$sql_preop = "INSERT INTO preop (protocol_nu, patient_nu, height, weight, bmi, muscle_mass, fat_mass, fat_percentage) 
              VALUES ('$protocol_nu', '$patient_nu', 0, 0, 0, 0, 0, 0)";

if ($conn->query($sql_patients) === TRUE && $conn->query($sql_preop) === TRUE) {
    $protocol_nu = $conn->real_escape_string($protocol_nu);
    echo "success";
} else {
    echo "Hasta eklenirken hata oluştu: " . $conn->error;
}

$conn->close();
?>
