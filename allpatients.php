<?php
require_once('includes/dbconnection.php');

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$records_per_page = 50;

$sql_count = "SELECT COUNT(*) AS total FROM patients";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];

$total_pages = ceil($total_records / $records_per_page);

$offset = ($page - 1) * $records_per_page;

$sql = "SELECT name_surname, surgery_name, surgery_date, protocol_nu 
        FROM patients 
        LIMIT $offset, $records_per_page";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tüm Hastalar</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="allpatients-container">
        <h2>Tüm Hastalar</h2>

        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>&laquo; Önceki</a>";
            }

            $start = max(1, $page - 5);
            $end = min($start + 9, $total_pages);

            for ($i = $start; $i <= $end; $i++) {
                $active_class = ($page == $i) ? 'active' : '';
                echo "<a href='?page=$i' class='$active_class'>$i</a>";
            }

            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "'>Sonraki &raquo;</a>";
            }
            ?>
        </div>

        <table class="results-table">
            <tr>
                <th>İsim Soyisim</th>
                <th>Ameliyat Adı</th>
                <th>Ameliyat Tarihi</th>
                <th>Protokol Numarası</th>
                <th>Detay</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row["name_surname"]) ?></td>
                    <td><?= htmlspecialchars($row["surgery_name"]) ?></td>
                    <td><?= htmlspecialchars($row["surgery_date"]) ?></td>
                    <td><?= htmlspecialchars($row["protocol_nu"]) ?></td>
                    <td><a href='details.php?protocol_nu=<?= urlencode($row["protocol_nu"]) ?>'>Detay</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>&laquo; Önceki</a>";
            }

            $start = max(1, $page - 5);
            $end = min($start + 9, $total_pages);

            for ($i = $start; $i <= $end; $i++) {
                $active_class = ($page == $i) ? 'active' : '';
                echo "<a href='?page=$i' class='$active_class'>$i</a>";
            }

            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "'>Sonraki &raquo;</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
