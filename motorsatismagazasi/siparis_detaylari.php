<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bağlantı dahil
include 'baglanti.php';

// URL'den siparis_id'yi al
if (!isset($_GET['siparis_id']) || !is_numeric($_GET['siparis_id'])) {
    // Geçersiz ID durumunda hata mesajı göster ve çık
    die('Geçersiz sipariş ID belirtildi.');
}
$siparis_id = intval($_GET['siparis_id']); // Tam sayıya çevirerek güvenliği artır

// Müşteri Bilgileri ve Siparişin Temel Bilgilerini Getir
$sql = "SELECT s.siparis_id, s.siparis_tarihi, m.ad AS MusteriAd, m.soyad AS MusteriSoyad, m.telefon AS Telefon, m.email AS Email, m.adres AS Adres
        FROM siparis s
        JOIN musteri m ON s.musteri_id = m.musteri_id
        WHERE s.siparis_id = $siparis_id";

$result = $baglanti->query($sql);

if ($result->num_rows > 0) {
    $siparis = $result->fetch_assoc();
} else {
    die('Belirtilen sipariş ID ile sipariş bulunamadı.');
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sipariş Detayları - Sipariş ID: <?php echo htmlspecialchars($siparis_id); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { background-color: #f8f9fa; }
.container { margin-top: 30px; }
</style>
</head>
<body>

<div class="container my-4">
    <h2 class="mb-4">Sipariş Detayları (ID: <?php echo htmlspecialchars($siparis_id); ?>)</h2>
    <p><strong>Sipariş Tarihi:</strong> <?php echo htmlspecialchars($siparis['siparis_tarihi']); ?></p>

    <!-- Müşteri Bilgileri -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">Müşteri Bilgileri</div>
        <div class="card-body">
            <p><strong>İsim Soyisim:</strong> <?php echo htmlspecialchars($siparis['MusteriAd'] . ' ' . $siparis['MusteriSoyad']); ?></p>
            <p><strong>Telefon:</strong> <?php echo htmlspecialchars($siparis['Telefon']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($siparis['Email']); ?></p>
            <p><strong>Adres:</strong> <?php echo htmlspecialchars($siparis['Adres']); ?></p>
        </div>
    </div>

    <!-- Motor ve tutar tablosu - Sipariş Detayları -->
    <h3 class="mb-3">Sipariş Edilen Ürünler</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Motor Modeli</th>
                <th>Miktar</th>
                <th>Birim Fiyat</th>
                <th>Satır Toplamı</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Siparişin detay kalemlerini getir
            $sqlDetay = "SELECT od.Miktar, od.Tutar, m.Model AS MotorModel, m.Fiyat AS BirimFiyat 
                         FROM siparis_detaylari od
                         JOIN motor m ON od.Motor_ID = m.Motor_ID
                         WHERE od.Siparis_ID = $siparis_id";


            $detayResult = $baglanti->query($sqlDetay);

            if ($detayResult->num_rows > 0) {
                 while ($detay = $detayResult->fetch_assoc()) {
                     echo "<tr>";
                     // Motor ID yerine çekilen Motor Modelini yazdırıyoruz
                     echo "<td>" . htmlspecialchars($detay['MotorModel']) . "</td>"; // Alias adı kullanılıyor
                     echo "<td>" . htmlspecialchars($detay['Miktar']) . "</td>";
                     echo "<td>" . htmlspecialchars($detay['BirimFiyat']) . "</td>";
                     echo "<td>" . htmlspecialchars($detay['Tutar']) . "</td>";
                     echo "</tr>";
                 }
            } else {
                 echo "<tr><td colspan='4'>Bu sipariş için ürün detayı bulunamadı.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="mt-3">
        <a href="siparis_listele.php" class="btn btn-secondary">Sipariş Listesine Dön</a>
    </div>

</div>

</body>
</html>