<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'baglanti.php';

$siparis_id = 0; // Varsayılan değer
$siparis = null; // Sipariş detayları
$mesaj = "";
$mesaj_tipi = "";

// Form gönderildiğinde (POST isteği) güncelleme işlemini yap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen güncel verileri al
    $siparis_id = (int)$_POST['siparis_id']; // Gizli inputtan gelir
    $musteri_id = (int)$_POST['musteri'];
    $motor_id = (int)$_POST['motor'];
    $miktar = (int)$_POST['miktar'];
    $birim_fiyat = (float)$_POST['birim_fiyat']; // Gizli inputtan gelir
    // Toplam tutarı yeniden hesapla
    $yeni_tutar = $miktar * $birim_fiyat;


    // Geçerli bir siparis_id ve miktar var mı kontrol et
    if ($siparis_id > 0 && $miktar > 0) {

        // Not: Siparişin ana bilgilerini (Müşteri ve Tarih) güncellemek isterseniz,
        // 'siparis' tablosu için de UPDATE sorgusu yazmanız gerekir.
        // Şu anki senaryoda genellikle sipariş detayları (motor, miktar) güncellenir.
        // Eğer müşteri veya tarih güncellenecekse, bu kısma ekleyebilirsiniz.

        // Sipariş detayını güncelle
        // phpMyAdmin yapısına göre 'Siparis_ID', 'Motor_ID', 'Miktar', 'Tutar' sütun adlarını kullanıyoruz.
        $sqlGuncelleDetay = "UPDATE siparis_detaylari SET Motor_ID = ?, Miktar = ?, Tutar = ? WHERE Siparis_ID = ?";
        $stmtGuncelleDetay = $baglanti->prepare($sqlGuncelleDetay);
        // Bağlama tipleri: Motor_ID integer (i), Miktar integer (i), Tutar double (d), WHERE Siparis_ID integer (i)
        $stmtGuncelleDetay->bind_param("iiid", $motor_id, $miktar, $yeni_tutar, $siparis_id);

        if ($stmtGuncelleDetay->execute()) {
             // İsteğe bağlı: Stok miktarını güncelle (Eski ve yeni miktarı hesaplayıp farkı stoğa ekle/çıkar)
             // Bu biraz daha karmaşıktır ve mevcut stok ve yeni miktar arasındaki farkı bulmayı gerektirir.
             // Şimdilik bunu atlıyorum, sadece sipariş detayını güncelledik.
             // Eğer stok güncellemesi gerekiyorsa, eski miktarı da çekmeniz gerekir.

            $mesaj = "Sipariş detayları başarıyla güncellendi. Sipariş ID: " . $siparis_id;
            $mesaj_tipi = "success";

             // Güncelleme başarılı olduktan sonra, güncel verileri tekrar çekip formda göstermek için
             // $siparis değişkenini yeniden doldurabiliriz veya kullanıcıyı listeleme sayfasına yönlendirebiliriz.
             // Genellikle listeleme sayfasına yönlendirmek daha yaygındır.
             header("Location: siparisleri_listele.php");
             exit(); // Yönlendirme sonrası scripti durdur

        } else {
            $mesaj = "Sipariş detayları güncellenirken hata oluştu: " . $stmtGuncelleDetay->error;
            $mesaj_tipi = "danger";
        }

        $stmtGuncelleDetay->close(); // Statement'ı kapat

    } else {
        $mesaj = "Geçersiz sipariş bilgisi veya miktar.";
        $mesaj_tipi = "danger";
    }

} else {
    // Sayfa ilk yüklendiğinde (GET isteği) sipariş detaylarını çek ve formu doldur
    if (isset($_GET['siparis_id'])) {
        $siparis_id = (int)$_GET['siparis_id'];

        if ($siparis_id > 0) {
            // Siparişin mevcut detaylarını veritabanından çek
            // siparis ve siparis_detaylari tablolarını join yaparak bilgileri alıyoruz.
            // Ayrıca, motor tablosundan da Marka, Model, Fiyat ve Stok_Miktarı bilgilerini alalım
            // ki formda bunları gösterebilelim ve güncel stok kontrolü yapabilelim.
            $sqlSiparisDetayCek = "
                SELECT
                    s.Siparis_ID,
                    s.Musteri_ID,
                    s.Tarih,
                    sd.Siparis_Detay_ID,
                    sd.Motor_ID,
                    sd.Miktar AS Siparis_Miktar, -- Siparişin miktarını adlandırdık
                    sd.Tutar AS Detay_Tutar,    -- Detay satırının tutarını adlandırdık
                    m.Marka,
                    m.Model,
                    m.Fiyat AS Motor_Fiyat,      -- Motorun güncel fiyatını adlandırdık
                    m.Stok_Miktarı AS Stok        -- Motorun güncel stokunu adlandırdık
                FROM
                    siparis s
                JOIN
                    siparis_detaylari sd ON s.Siparis_ID = sd.Siparis_ID
                JOIN
                    motor m ON sd.Motor_ID = m.Motor_ID
                WHERE
                    s.Siparis_ID = ?
                LIMIT 1"; // Tek bir sipariş detayı bekliyoruz

            $stmtSiparisDetayCek = $baglanti->prepare($sqlSiparisDetayCek);
            $stmtSiparisDetayCek->bind_param("i", $siparis_id); // 'i' integer için
            $stmtSiparisDetayCek->execute();
            $resultSiparis = $stmtSiparisDetayCek->get_result();

            if ($resultSiparis->num_rows > 0) {
                $siparis = $resultSiparis->fetch_assoc(); // Sipariş detaylarını al
            } else {
                $mesaj = "Sipariş bulunamadı.";
                $mesaj_tipi = "danger";
            }

            $stmtSiparisDetayCek->close(); // Statement'ı kapat

        } else {
            $mesaj = "Geçersiz Sipariş ID.";
            $mesaj_tipi = "danger";
        }
    } else {
        $mesaj = "Güncellenecek sipariş ID'si belirtilmedi.";
        $mesaj_tipi = "warning";
    }
}

// Form için müşteri ve motor verilerini çek (Güncelleme formunda da kullanmak için)
$sqlMusteri = "SELECT musteri_id, ad, soyad FROM musteri ORDER BY ad ASC";
$resultMusteri = $baglanti->query($sqlMusteri);

$sqlMotor = "SELECT Motor_ID, Marka, Model, Fiyat, Stok_Miktarı AS Stok FROM motor ORDER BY Marka ASC";
$resultMotor = $baglanti->query($sqlMotor);

$baglanti->close(); // Veritabanı bağlantısını kapat

?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sipariş Güncelle (ID: <?php echo $siparis_id; ?>)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.container { margin-top: 30px; }
</style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Sipariş Güncelle (ID: <?php echo $siparis_id; ?>)</h2>

    <?php if (isset($mesaj)): ?>
        <div class="alert alert-<?php echo $mesaj_tipi; ?> alert-dismissible fade show" role="alert">
            <?php echo $mesaj; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($siparis): // Sipariş detayları çekilebildiyse formu göster ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <!-- Sipariş ID'sini gizli input ile gönder -->
        <input type="hidden" name="siparis_id" value="<?php echo $siparis['Siparis_ID']; ?>">

        <div class="mb-3">
            <label for="musteri" class="form-label">Müşteri Seçin:</label>
            <select class="form-select" id="musteri" name="musteri" required>
                <option value="">Müşteri Seçiniz</option>
                <?php
                // Müşteri listesini doldur ve mevcut müşteriyi seçili yap
                if ($resultMusteri && $resultMusteri->num_rows > 0) {
                    // Veritabanı bağlantısı kapatıldığı için motor ve müşteri sonuçlarını tekrar almanız gerekebilir
                    // veya bağlantıyı kapatmadan önce bu döngüleri çalıştırmanız gerekir.
                    // En iyisi, bu sorguları form gösterilmeden hemen önce çalıştırmak.
                    // Şu anki yapıya göre, bu sonuçları tekrar çekelim (veya veritabanı bağlantısını formun sonuna taşıyalım)
                    // Bağlantıyı formun sonuna taşıdım.
                    $baglanti = include 'baglanti.php'; // Bağlantıyı yeniden açalım (veya yukarı taşıyalım)
                     $sqlMusteri = "SELECT musteri_id, ad, soyad FROM musteri ORDER BY ad ASC";
                     $resultMusteri = $baglanti->query($sqlMusteri);

                    while($rowMusteri = $resultMusteri->fetch_assoc()) {
                         $selected = ($rowMusteri['musteri_id'] == $siparis['Musteri_ID']) ? 'selected' : '';
                        echo "<option value='" . $rowMusteri['musteri_id'] . "' " . $selected . ">" . htmlspecialchars($rowMusteri['ad'] . ' ' . $rowMusteri['soy ad']) . "</option>";
                    }
                    $resultMusteri->free(); // Sonuç setini serbest bırak
                } else {
                    echo "<option value='' disabled>Müşteri bulunamadı.</option>";
                }
                ?>
            </select>
             <!-- Not: Müşteri ID'sini güncelleme işlemi bu kodda yapılmıyor, sadece formda gösteriliyor -->
             <!-- Eğer müşteri güncellenecekse, yukarıdaki POST bloğuna 'siparis' tablosu için UPDATE sorgusu eklemelisiniz -->
        </div>

        <div class="mb-3">
            <label for="motor" class="form-label">Motor Seçin:</label>
            <select class="form-select" id="motor" name="motor" required>
                <option value="">Motor Seçiniz</option>
                 <?php
                 // Motor listesini doldur ve mevcut motoru seçili yap
                 // Bağlantıyı yeniden açalım (veya yukarı taşıyalım)
                 $baglanti = include 'baglanti.php';
                 $sqlMotor = "SELECT Motor_ID, Marka, Model, Fiyat, Stok_Miktarı AS Stok FROM motor ORDER BY Marka ASC";
                 $resultMotor = $baglanti->query($sqlMotor);

                if ($resultMotor && $resultMotor->num_rows > 0) {
                    while($rowMotor = $resultMotor->fetch_assoc()) {
                         $selected = ($rowMotor['Motor_ID'] == $siparis['Motor_ID']) ? 'selected' : '';
                         // Data attribute olarak fiyat ve stok ekliyoruz (JavaScript ile erişmek için)
                        echo "<option value='" . $rowMotor['Motor_ID'] . "' data-fiyat='" . $rowMotor['Fiyat'] . "' data-stok='" . $rowMotor['Stok'] . "' " . $selected . ">" . htmlspecialchars($rowMotor['Marka'] . ' ' . $rowMotor['Model'] . ' (Stok: ' . $rowMotor['Stok'] . ')') . "</option>";
                    }
                     $resultMotor->free(); // Sonuç setini serbest bırak
                } else {
                    echo "<option value='' disabled>Motor bulunamadı.</option>";
                }
                 // Bağlantıyı kapat (sorgular bittikten sonra)
                 $baglanti->close();
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="miktar" class="form-label">Miktar:</label>
            <input type="number" class="form-control" id="miktar" name="miktar" min="1" required value="<?php echo $siparis['Siparis_Miktar']; ?>">
            <!-- Stok miktarını göstermek için boş bir span -->
            <small class="form-text text-muted" id="stokBilgisi"></small>
            <!-- Seçilen motorun birim fiyatını gizli inputta saklayacağız -->
            <!-- Mevcut motorun fiyatını başlangıçta gizli inputa set et -->
            <input type="hidden" id="birim_fiyat" name="birim_fiyat" value="<?php echo $siparis['Motor_Fiyat']; ?>">
        </div>

         <!-- Sipariş Tarihi (İsteğe bağlı olarak gösterilebilir, genellikle değiştirilmez) -->
        <div class="mb-3">
            <label for="siparis_tarihi" class="form-label">Sipariş Tarihi:</label>
            <input type="text" class="form-control" id="siparis_tarihi" value="<?php echo htmlspecialchars($siparis['Tarih']); ?>" readonly>
        </div>


        <!-- JavaScript ile Miktar alanına maksimum stok değerini ve Birim Fiyatı set etme -->
        <script>
            const motorSelect = document.getElementById('motor');
            const miktarInput = document.getElementById('miktar');
            const stokBilgisi = document.getElementById('stokBilgisi');
            const birimFiyatInput = document.getElementById('birim_fiyat');

            // Fonksiyon: Seçili motorun stok ve fiyat bilgilerini günceller
            function updateMotorInfo() {
                 const selectedOption = motorSelect.options[motorSelect.selectedIndex];
                 const stok = selectedOption.getAttribute('data-stok');
                 const fiyat = selectedOption.getAttribute('data-fiyat');

                 // Stok bilgisini gösterme ve miktar inputunun max değerini set etme
                 if (stok !== null && stok !== "") {
                     stokBilgisi.textContent = 'Maksimum Stok: ' + stok;
                     // Miktar alanının max değerini integer'a dönüştürerek set et
                     miktarInput.max = parseInt(stok, 10);
                     // Eğer mevcut miktar maksimum stoku aşarsa, miktar alanını max stoğa eşitle
                     if (parseInt(miktarInput.value, 10) > parseInt(stok, 10)) {
                          miktarInput.value = parseInt(stok, 10);
                     }
                 } else {
                     stokBilgisi.textContent = 'Stok bilgisi mevcut değil.';
                     miktarInput.removeAttribute('max');
                      miktarInput.value = 1; // Stok yoksa veya bilgi gelmezse miktarı 1 yap
                 }

                 // Birim fiyatı gizli inputa set etme
                 if (fiyat !== null && fiyat !== "") {
                      birimFiyatInput.value = parseFloat(fiyat).toFixed(2);
                 } else {
                      birimFiyatInput.value = '0.00'; // Fiyat bilgisi yoksa 0.00 yap
                 }
            }

            // Motor seçimi değiştiğinde bilgiyi güncelle
            motorSelect.addEventListener('change', updateMotorInfo);

            // Sayfa yüklendiğinde (veya sipariş detayları çekildiğinde) mevcut motorun stok ve fiyat bilgisini göster
            // Bu, form yüklendiğinde mevcut siparişin motor bilgisinin görüntülenmesini sağlar
             updateMotorInfo(); // Sayfa yüklendiğinde fonksiyonu çağır

        </script>


        <button type="submit" class="btn btn-primary">Güncellemeyi Kaydet</button>
        <a href="siparisleri_listele.php" class="btn btn-secondary">İptal ve Listeye Dön</a>

    </form>

    <?php else: // Sipariş bulunamadıysa veya geçerli ID yoksa formu gösterme ?>
         <p class="alert alert-info">Güncellenecek sipariş detayları bulunamadı.</p>
         <a href="siparisleri_listele.php" class="btn btn-secondary">Sipariş Listesine Dön</a>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>