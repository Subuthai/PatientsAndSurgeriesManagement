<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasta Ekle</title>
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
    
    h1 {
        color: #333;
        margin-top: 0;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
    }
    
    form {
        margin-top: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
    }
    
    input[type="text"], input[type="date"], input[type="submit"] {
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
        .addpatient-container {
            padding: 10px;
            border-radius: 0;
            box-shadow: none;
        }
    
        input[type="text"], input[type="date"], input[type="submit"] {
            width: 100%;
        }
    }

    </style>
    <div class="addpatient-container">
        <h1>Hasta Ekle</h1>
        <form id="addPatientForm" action="includes/add_patient_process.php" method="POST">
            <label for="name_surname">İsim Soyisim:</label><br>
            <input type="text" id="name_surname" name="name_surname" required><br><br>

            <label for="protocol_nu">Protokol Numarası:</label><br>
            <input type="text" id="protocol_nu" name="protocol_nu" required><br><br>

            <label for="patient_nu">Hasta Numarası:</label><br>
            <input type="text" id="patient_nu" name="patient_nu" required><br><br>

            <label for="surgery_name">Ameliyat Adı:</label><br>
            <input type="text" id="surgery_name" name="surgery_name" required><br><br>

            <label for="surgery_date">Ameliyat Tarihi:</label><br>
            <input type="date" id="surgery_date" name="surgery_date" required><br><br>

            <input type="submit" value="Hasta Ekle">
        </form>
    </div>

    <script>
document.getElementById('addPatientForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var form = this;
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            var response = xhr.responseText;
            if (response.trim() === 'success') {
                var protocolNu = encodeURIComponent(document.getElementById('protocol_nu').value.trim());
                window.location.href = 'details.php?protocol_nu=' + protocolNu;
            } else {
                alert(response);
            }
        } else {
            alert('Hata oluştu. Lütfen tekrar deneyiniz.');
        }
    };

    xhr.onerror = function() {
        alert('Sunucu hatası! İşlem gerçekleştirilemedi.');
    };

    xhr.send(formData);
});
</script>


</body>
</html>
