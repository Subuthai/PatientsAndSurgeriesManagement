<?php
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('includes/dbconnection.php');

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $protocol_nu = $conn->real_escape_string($_POST['protocol_nu']);
    $table = $conn->real_escape_string($_POST['table']);

    $sql = "INSERT INTO $table (protocol_nu, patient_nu, height, weight, bmi, muscle_mass, fat_mass, fat_percentage)
            VALUES ('$protocol_nu', '0', '0', '0', '0', '0', '0', '0')";

    if ($conn->query($sql) === TRUE) {
        header("Location: edit_table.php?table=$table&protocol_nu=" . urlencode($protocol_nu));
        exit;
    } else {
        echo "Veri eklenirken hata oluştu: " . $conn->error;
    }

    $conn->close();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veri Ekle</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container">
        <h2>Veri Ekle</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="protocol_nu" value="<?php echo htmlspecialchars($_GET['protocol_nu']); ?>">
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($_GET['table']); ?>">
            <input type="submit" value="Veri Ekle">
        </form>
    </div>
</body>
</html>
