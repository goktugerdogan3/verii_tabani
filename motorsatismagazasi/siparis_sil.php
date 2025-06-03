<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'baglanti.php'; // Veritabanı bağlantısını dahil et

// Session'ı başlat
session_start();

$mesaj = ""; // Mesaj değişkenini başlat
$mesaj_tipi = ""; // Mesaj tipi değişkenini başlat

// Silme işlemi sadece GET isteği ile ve siparis_id parametresi varsa yapılır
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['siparis_id'])) {
    // Siparis ID'sini al ve tam sayıya dönüştür
    $siparis_id = (int)$_GET['siparis_id'];

    // Eğer siparis_id geçerli bir tam sayı ise (0 değilse)
    if ($siparis_id > 0) {
        // Transaction başlatma (isteğe bağlı ama veri bütünlüğü için iyi)
        $baglanti->begin_transaction();

        // Sipariş detaylarını sil (önce detaylar silinmeli, sonra ana sipariş)
        $sqlDeleteDetaylar = "DELETE FROM siparis_detaylari WHERE Siparis_ID = ?";
        $stmtDeleteDetaylar = $baglanti->prepare($sqlDeleteDetaylar);

        if ($stmtDeleteDetaylar === false) {
             $mesaj = "Detay silme sorgusu hazırlanırken hata oluştu: " . $baglanti->error;
             $mesaj_tipi = "danger";
             $baglanti->rollback(); // Hata olursa transaction'ı geri al
        } else {
            $stmtDeleteDetaylar->bind_param("i", $siparis_id); // 'i' integer için

            if ($stmtDeleteDetaylar->execute()) {
                // Sipariş detayları başarıyla silindiyse, ana siparişi sil
                $sqlDeleteSiparis = "DELETE FROM siparis WHERE Siparis_ID = ?";
                $stmtDeleteSiparis = $baglanti->prepare($sqlDeleteSiparis);

                 if ($stmtDeleteSiparis === false) {
                     $mesaj = "Ana sipariş silme sorgusu hazırlanırken hata oluştu: " . $baglanti->error;
                     $mesaj_tipi = "danger";
                     $baglanti->rollback(); // Hata olursa transaction'ı geri al
                 } else {
                    $stmtDeleteSiparis->bind_param("i", $siparis_id); // 'i' integer için

                    if ($stmtDeleteSiparis->execute()) {
                        // Her iki silme işlemi de başarılıysa commit yap
                        $baglanti->commit();
                        $mesaj = "Sipariş ve detayları başarıyla silindi. Sipariş ID: " . $siparis_id;
                        $mesaj_tipi = "success";
                    } else {
                        // Ana sipariş silinirken hata oluştuysa geri al
                        $baglanti->rollback();
                        $mesaj = "Sipariş detayları silindi ancak ana sipariş silinirken hata oluştu: " . $stmtDeleteSiparis->error;
                        $mesaj_tipi = "warning"; // Uyarı mesajı
                    }
                    $stmtDeleteSiparis->close(); // Statement'ı kapat
                 }

            } else {
                // Detaylar silinirken hata oluştuysa geri al
                $baglanti->rollback();
                $mesaj = "Sipariş detayları silinirken hata oluştu: " . $stmtDeleteDetaylar->error;
                $mesaj_tipi = "danger"; // Hata mesajı
            }
            $stmtDeleteDetaylar->close(); // Statement'ı kapat
        }


    } else {
        $mesaj = "Geçersiz Sipariş ID belirtildi.";
        $mesaj_tipi = "danger"; // Hata mesajı
    }

} else {
    $mesaj = "Silme işlemi için geçerli bir istek yapılmadı.";
    $mesaj_tipi = "warning"; // Uyarı mesajı
}

// Mesajı session'a kaydet
$_SESSION['mesaj'] = $mesaj;
$_SESSION['mesaj_tipi'] = $mesaj_tipi;

// Kullanıcıya mesajı gösteren ve 3 saniye sonra yönlendiren bir HTML sayfası oluştur
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İşlem Sonucu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .message-box {
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        /* Mesaj tipine göre arka plan rengi */
        .alert-success { background-color: #d4edda; color:rgb(0, 0, 0); border-color:rgb(128, 36, 22); } /* Yeşil - Başarı */
        .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; } /* Kırmızı - Hata */
        .alert-warning { background-color: #fff3cd; color: #856404; border-color: #ffeeba; } /* Sarı - Uyarı */

    </style>
    <!-- Meta refresh ile 3 saniye sonra yönlendirme -->
    <meta http-equiv="refresh" content="5;url=siparis_listele.php">
</head>
<body>

<div class="message-box alert alert-<?php echo $mesaj_tipi; ?>">
    <h2><?php echo htmlspecialchars($mesaj); ?></h2>
    <p>Birazdan sipariş listesi sayfasına yönlendirileceksiniz...</p>
    <p><a href="siparisleri_listele.php" class="alert-link">Hemen gitmek için tıklayın</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Veritabanı bağlantısını kapat
$baglanti->close();
?>