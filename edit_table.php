<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablo Düzenleme</title>
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
    h2 {
        color: #333;
        margin-top: 0;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
    }
    form {
    margin-top: 20px;
    }
    input[type="text"], input[type="submit"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .error-message {
    color: #dc3545;
    margin-top: 10px;
    }
    @media (max-width: 768px) {
    input[type="text"], input[type="submit"] {
        width: 100%;
     }
    }
    </style>
    <div class="edit-container">
        <h2>Tablo Düzenleme</h2>

        <?php
        require_once('includes/dbconnection.php');

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        $table = $_GET['table'];
        $protocol_nu = $_GET['protocol_nu'];

        $sql = "SELECT * FROM $table WHERE protocol_nu = '$protocol_nu'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<form action='includes/update_table.php' method='POST'>";
            echo "<input type='hidden' name='table' value='$table'>";
            echo "<input type='hidden' name='protocol_nu' value='$protocol_nu'>";
            echo "<input type='hidden' name='patient_nu' value='" . htmlspecialchars($row['patient_nu']) . "'>";

            foreach ($row as $column => $value) {
                if ($column != 'protocol_nu' && $column != 'patient_nu') {
                    echo "<label for='$column'>$column:</label><br>";
                    echo "<input type='text' id='$column' name='$column' value='" . htmlspecialchars($value) . "'><br><br>";
                }
            }

            echo "<input type='submit' value='Güncelle'>";
            echo "</form>";
        } else {
            echo "<p>Tablo bulunamadı veya geçersiz protokol numarası.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
