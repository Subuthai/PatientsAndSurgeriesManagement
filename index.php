<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama Sayfası</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <style>
    body {
        height: 100vh;
    }
    </style>
    <div class="search-container">
        <h1>Ana Sayfa</h1>
        <form action="search.php" method="get">
            <input type="text" name="search_term" placeholder="İsim, Protokol veya Hasta Numarası">
            <button type="submit">Ara</button>
        </form>
        <div class="button-container">
        <a href="allpatients.php" class="button">Bütün Hastaları Listele</a>
        <a href="add_patient.php" class="button">Hasta Ekle</a>
        </div>
    </div>
</body>
</html>
