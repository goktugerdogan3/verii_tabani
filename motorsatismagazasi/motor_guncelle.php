<?php  
include 'baglanti.php'; // Veritabanı bağlantısı  

// Geçersiz veya eksik Motor_ID kontrolü  
if (!isset($_GET['Motor_ID']) || !is_numeric($_GET['Motor_ID'])) {  
    // Geçersiz ID mesajı (Bootstrap ile)  
    echo "<div class='container mt-5'><div class='alert alert-danger text-center' role='alert' style='font-size:24px;'><strong>Geçersiz motor ID!</strong></div></div>";  
    exit;  
}  

$Motor_ID = intval($_GET['Motor_ID']);  

// Veritabanından motor kaydını getir  
$result = $baglanti->query("SELECT * FROM motor WHERE Motor_ID = $Motor_ID");  
if ($result && $result->num_rows > 0) {  
    $motor = $result->fetch_assoc();  
} else {  
    // Motor bulunamadı mesajı (Bootstrap ile)  
    echo "<div class='container mt-5'><div class='alert alert-danger text-center' role='alert' style='font-size:24px;'><strong>Motor bulunamadı!</strong></div></div>";  
    exit;  
}  

// Form gönderildiyse güncelleme işlemini yap  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $Marka = $_POST['Marka'];  
    $Model = $_POST['Model'];  
    $Fiyat = $_POST['Fiyat'];  
    $Stok_Miktarı = $_POST['Stok_Miktarı'];  
    $Yıl = $_POST['Yıl']; // Formdan gelen 'Yıl' değerini al  

    // SQL Injection'a karşı koruma  
    $Marka = mysqli_real_escape_string($baglanti, $Marka);  
    $Model = mysqli_real_escape_string($baglanti, $Model);  
    $Fiyat = mysqli_real_escape_string($baglanti, $Fiyat);  
    $Stok_Miktarı = mysqli_real_escape_string($baglanti, $Stok_Miktarı);  
    $Yıl = mysqli_real_escape_string($baglanti, $Yıl);  

    // Güncelleme sorgusu  
    $sql_guncelle = "UPDATE motor SET   
                      Marka='$Marka',   
                      Model='$Model',   
                      Fiyat='$Fiyat',   
                      Stok_Miktarı='$Stok_Miktarı',   
                      Yıl='$Yıl'   
                    WHERE Motor_ID=$Motor_ID";  

    if ($baglanti->query($sql_guncelle)) {  
        // Başarılı güncelleme mesajı (Kutu içinde, ortalanmış, yeşil)  
        echo "  
        <!DOCTYPE html>  
        <html lang='tr'>  
        <head>  
            <meta charset='UTF-8'>  
            <title>Güncelleme Başarılı</title>  
            <meta name='viewport' content='width=device-width, initial-scale=1'>  
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>  
            <style>  
                body {  
                    background-color: #f8f9fa; /* Açık gri arka plan */  
                    display: flex; /* İçeriği ortalamak için */  
                    justify-content: center; /* Yatayda ortala */  
                    align-items: center; /* Dikeyde ortala */  
                    min-height: 100vh; /* Ekran yüksekliği kadar minimum yükseklik */  
                    margin: 0; /* Varsayılan margin'i kaldır */  
                }  
                .success-box {  
                    border: 3px solid #28a745; /* Yeşil kenarlık */  
                    box-shadow: 0 0 20px rgba(40, 167, 69, 0.5); /* Yeşil gölge */  
                    max-width: 500px; /* Maksimum genişlik */  
                    width: 100%; /* Küçük ekranlarda %100 genişlik */  
                    padding: 30px; /* İç boşluk */  
                    border-radius: 8px; /* Köşe yuvarlaklığı */  
                    background-color: #d4edda; /* Açık yeşil arka plan */  
                    color: #155724; /* Koyu yeşil yazı rengi */  
                    text-align: center; /* Yazıyı ortala */  
                }  
                .success-box h3 {  
                    color: #155724; /* Başlık rengi */  
                    margin-bottom: 20px;  
                }  
                .success-box p {  
                    font-size: 20px;  
                    margin-bottom: 10px;  
                }  
                .success-box .muted-text {  
                    font-size: 16px;  
                    color: #155724; /* Yönlendirme yazısı rengi */  
                    opacity: 0.8; /* Hafif şeffaflık */  
                }  
            </style>  
        </head>  
        <body>  
        <div class='success-box'>  
            <h3>Güncelleme Başarılı!</h3>  
            <p>Güncelleme işleminiz başarıyla tamamlandı.</p>  
            <p class='muted-text'>Motor listesine yönlendiriliyorsunuz...</p>  
        </div>  
        <script>  
            setTimeout(function() {  
                window.location.href='motor_listele.php';  
            }, 3000);  
        </script>  
        </body>  
        </html>";  
        exit;  
    } else {  
        // Güncelleme hatası mesajı (Kutu içinde, ortalanmış, kırmızı)  
        echo "  
        <!DOCTYPE html>  
        <html lang='tr'>  
        <head>  
            <meta charset='UTF-8'>  
            <title>Güncelleme Başarısız</title>  
            <meta name='viewport' content='width=device-width, initial-scale=1'>  
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>  
            <style>  
                body {  
                    background-color: #f8f9fa; /* Açık gri arka plan */  
                    display: flex; /* İçeriği ortalamak için */  
                    justify-content: center; /* Yatayda ortala */  
                    align-items: center; /* Dikeyde ortala */  
                    min-height: 100vh; /* Ekran yüksekliği kadar minimum yükseklik */  
                    margin: 0; /* Varsayılan margin'i kaldır */  
                }  
                .error-box {  
                    border: 3px solid #dc3545; /* Kırmızı kenarlık */  
                    box-shadow: 0 0 20px rgba(220, 53, 69, 0.5); /* Kırmızı gölge */  
                    max-width: 500px; /* Maksimum genişlik */  
                    width: 100%; /* Küçük ekranlarda %100 genişlik */  
                    padding: 30px; /* İç boşluk */  
                    border-radius: 8px; /* Köşe yuvarlaklığı */  
                    background-color: #f8d7da; /* Açık kırmızı arka plan */  
                    color: #721c24; /* Koyu kırmızı yazı rengi */  
                    text-align: center; /* Yazıyı ortala */  
                }  
                .error-box h3 {  
                    color: #721c24; /* Başlık rengi */  
                    margin-bottom: 20px;  
                }  
                .error-box p {  
                    font-size: 20px;  
                    margin-bottom: 10px;  
                }  
                 .error-box .muted-text {  
                    font-size: 16px;  
                    color: #721c24; /* Yönlendirme yazısı rengi */  
                     opacity: 0.8; /* Hafif şeffaflık */  
                }  
            </style>  
        </head>  
        <body>  
        <div class='error-box'>  
            <h3>Güncelleme Başarısız!</h3>  
            <p>Hata: " . htmlspecialchars($baglanti->error) . "</p>  
            <p class='muted-text'>Motor listesine yönlendiriliyorsunuz...</p>  
        </div>  
        <script>  
            setTimeout(function() {  
                window.location.href='motor_listele.php';  
            }, 3000);  
        </script>  
        </body>  
        </html>";  
        exit;  
    }  
}  
?>  

<?php  
// Formu sadece POST isteği gelmediğinde göster (Başlangıç HTML etiketleri ve body tagı bu if'in dışında kalacak)  
if ($_SERVER['REQUEST_METHOD'] != 'POST') {  
?>  
<!DOCTYPE html>  
<html lang="tr">  
<head>  
    <meta charset="UTF-8">  
    <title>Motor Güncelle</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <style>  
        /* Bu stiller sadece form gösterildiğinde geçerli olur */  
        body {  
            background-color: #f8f9fa; /* Açık gri arka plan */  
        }  
        .card {  
            border: none; /* Kart kenarlığı yok */  
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* Hafif gölge */  
        }  
        .card-header {  
            border-bottom: none; /* Başlık altında çizgi yok */  
        }  
    </style>  
</head>  
<body>  

<div class="container" style="max-width:700px; margin-top: 40px;">  
    <div class="card">  
        <div class="card-header text-center bg-primary text-white">   
            <h4 class="mb-0">Motor Güncelle</h4>  
        </div>  
        <div class="card-body">  
            <form method="post" action="">  
                <div class="mb-3">  
                    <label for="Marka" class="form-label">Marka</label>  
                    <input type="text" id="Marka" name="Marka" class="form-control" value="<?php echo htmlspecialchars($motor['Marka']); ?>" required>  
                </div>  
                <div class="mb-3">  
                    <label for="Model" class="form-label">Model</label>  
                    <input type="text" id="Model" name="Model" class="form-control" value="<?php echo htmlspecialchars($motor['Model']); ?>" required>  
                </div>  
                <div class="mb-3">  
                    <label for="Fiyat" class="form-label">Fiyat</label>  
                    <input type="text" id="Fiyat" name="Fiyat" class="form-control" value="<?php echo htmlspecialchars($motor['Fiyat']); ?>" required>  
                </div>  
                <div class="mb-3">  
                    <label for="Stok_Miktarı" class="form-label">Stok Miktarı</label>  
                    <input type="number" id="Stok_Miktarı" name="Stok_Miktarı" class="form-control" value="<?php echo htmlspecialchars($motor['Stok_Miktarı']); ?>" required>  
                </div>  
                <div class="mb-3">  
                    <label for="Yıl" class="form-label">Yıl</label>  
                    <input type="number" id="Yıl" name="Yıl" class="form-control" value="<?php echo htmlspecialchars($motor['Yıl']); ?>" required>  
                </div>  
                <button type="submit" class="btn btn-primary w-100">Güncelle</button>   
            </form>  
        </div>  
    </div>  
</div>  

<!-- İsteğe bağlı olarak Bootstrap JS dosyalarını ekleyebilirsiniz -->  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  

</body>  
</html>  
<?php  
} // Form gösterme koşulunun sonu  
?>  