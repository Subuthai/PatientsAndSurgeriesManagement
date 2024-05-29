<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasta Detayları</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <style>
    body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}
h2, h3 {
    color: #333;
}
    </style>
    <div class="details-container">
        <?php
        require_once('includes/dbconnection.php');

        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }
        if (isset($_GET['protocol_nu'])) {
            $protocol_nu = $conn->real_escape_string($_GET['protocol_nu']);
            $where_condition = "protocol_nu = '$protocol_nu'";
        } elseif (isset($_GET['patient_nu'])) {
            $patient_nu = $conn->real_escape_string($_GET['patient_nu']);
            $where_condition = "patient_nu = '$patient_nu'";
        } else {
            die("Hasta numarası veya protokol numarası belirtilmedi.");
        }

        $sql = "SELECT * FROM patients WHERE $where_condition";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['protocol_nu'] == 0 || $row['patient_nu'] == 0) {
                die("<div class='error-message'>Hasta detayları bulunamadı.</div>");
            }

            echo "<h2 class='patient-heading'>Hasta Detayları</h2>";
            echo "<div class='patient-details'>";
            echo "<p><strong>Hasta Adı:</strong> " . htmlspecialchars($row["name_surname"]) . "</p>";
            echo "<p><strong>Protokol Numarası:</strong> " . htmlspecialchars($row["protocol_nu"]) . "</p>";
            echo "<p><strong>Hasta Numarası:</strong> " . htmlspecialchars($row["patient_nu"]) . "</p>";
            echo "<p><strong>Ameliyat Adı:</strong> " . htmlspecialchars($row["surgery_name"]) . "</p>";
            echo "<p><strong>Ameliyat Tarihi:</strong> " . htmlspecialchars($row["surgery_date"]) . "</p>";
            echo "</div>";

            $tables = [
                'preop',
                'postop_first_week',
                'postop_first_month',
                'postop_third_month',
                'postop_sixth_month',
                'postop_twelfth_month',
                'postop_twentyfourth_month'
            ];

            foreach ($tables as $table) {
                $sql = "SELECT protocol_nu, patient_nu, height, weight, bmi, muscle_mass, fat_mass, fat_percentage
                        FROM $table
                        WHERE $where_condition";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<h3 class='control-table-heading'>" . ucfirst(str_replace('_', ' ', $table)) . " Kontrol Tablosu</h3>";
                    echo "<table class='control-table'>
                            <tr>
                                <th>Boy</th>
                                <th>Kilo</th>
                                <th>BMI</th>
                                <th>Kas Kütlesi</th>
                                <th>Yağ Kütlesi</th>
                                <th>Yağ Yüzdesi</th>
                                <th>Düzenle</th>
                                <th>Sil</th>
                            </tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["height"] . "</td>
                                <td>" . $row["weight"] . "</td>
                                <td>" . $row["bmi"] . "</td>
                                <td>" . $row["muscle_mass"] . "</td>
                                <td>" . $row["fat_mass"] . "</td>
                                <td>" . $row["fat_percentage"] . "</td>
                                <td><a href='edit_table.php?table=$table&protocol_nu=" . urlencode($row["protocol_nu"]) . "'>Düzenle</a></td>
                                <td><a href='includes/delete_entry.php?table=$table&protocol_nu=" . urlencode($row["protocol_nu"]) . "'>Sil</a></td>

                              </tr>";
                    }
                    echo "</table><br>";
                } else {
                    echo "<h3 class='control-table-heading'>" . ucfirst(str_replace('_', ' ', $table)) . " Kontrol Tablosu</h3>";
                    echo "<p><a href='add_data.php?table=$table&protocol_nu=" . urlencode($protocol_nu) . "'>Veri Ekle</a></p><br>";
                    echo "<p>Operasyon sonrası kontrol tablosu bulunamadı.</p><br>";
                }
            }
        } else {
            echo "<div class='error-message'>Hastaya ait detay bulunamadı.</div>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
