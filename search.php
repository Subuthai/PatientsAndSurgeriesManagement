<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama Sonuçları</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container">
        <?php
        require_once('includes/dbconnection.php');

        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");
        
        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        if (isset($_GET['search_term'])) {
            $search_term = trim($conn->real_escape_string($_GET['search_term']));
            $search_term_like = "%" . $search_term . "%";

            $where_condition = "LOWER(name_surname) LIKE BINARY LOWER('$search_term_like') 
                                OR protocol_nu = '$search_term' 
                                OR patient_nu = '$search_term'";

            $sql = "SELECT name_surname, surgery_name, surgery_date, protocol_nu 
                    FROM patients 
                    WHERE $where_condition";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Arama Sonuçları</h2>";
                echo "<table class='results-table'>
                        <tr>
                            <th>İsim Soyisim</th>
                            <th>Ameliyat Adı</th>
                            <th>Ameliyat Tarihi</th>
                            <th>Protokol Numarası</th>
                            <th>Detay</th>
                        </tr>";

                $first_match_shown = false;

                while ($row = $result->fetch_assoc()) {
                    if (!$first_match_shown) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["name_surname"]) . "</td>
                                <td>" . htmlspecialchars($row["surgery_name"]) . "</td>
                                <td>" . htmlspecialchars($row["surgery_date"]) . "</td>
                                <td>" . htmlspecialchars($row["protocol_nu"]) . "</td>
                                <td><a href='details.php?protocol_nu=" . urlencode($row["protocol_nu"]) . "'>Detay</a></td>
                              </tr>";
                        $first_match_shown = true;
                    } else {
                        continue;
                    }
                }
                echo "</table>";
            } else {
                echo "<p>Arama terimiyle eşleşen hasta bulunamadı.</p>";
            }
        } else {
            echo "<p>Arama terimi belirtilmedi.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
