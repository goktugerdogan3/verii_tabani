<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bağlantı dahil
include 'baglanti.php';

// Tüm siparişleri getir - SQL sorgusuna motor tablosu JOIN edildi
// motor tablosundaki Model sütunu 'MotorModeli' aliası ile çekildi
$sql = "SELECT s.siparis_id, m.ad, m.soyad, od.Motor_ID, od.Miktar, od.Tutar, mo.Model AS MotorModeli -- <<< Burası güncellendi (mo.Model)
        FROM siparis s
        JOIN musteri m ON s.musteri_id = m.musteri_id
        JOIN siparis_detaylari od ON s.siparis_id = od.Siparis_ID
        JOIN motor mo ON od.Motor_ID = mo.Motor_ID";

$result = $baglanti->query($sql);

?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sipariş Listesi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { background-color: #f8f9fa; }
.container { margin-top: 30px; }
</style>
</head>
<body>

<div class="container my-4">
   
<h2 class="text-center mb-4">Motor Satış Sipariş Listesi</h2>
    

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Sipariş ID</th>
                <th>Müşteri Adı Soyadı</th>
                <th>Motor Modeli</th>
                <th>Miktar</th>
                <th>Tutar</th>
                <th>Sipariş Sil</th>
            </tr>
        </thead>
       <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['siparis_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ad'] . ' ' . $row['soyad']) . "</td>";
            echo "<td>" . htmlspecialchars($row['MotorModeli']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Miktar']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Tutar']) . "</td>";
            echo "<td>";
            
            echo "<a href='siparis_sil.php?siparis_id=" . $row['siparis_id'] . "' class='btn btn-danger btn-sm-1' onclick='return confirm(\"Bu siparişi silmek istediğinizden emin misiniz?\");'>Sil</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Henüz sipariş bulunmuyor.</td></tr>";
    }
    ?>
</tbody>
    </table>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Ana Sayfaya Dön</a>
    </div>

</div>

</body>
</html>