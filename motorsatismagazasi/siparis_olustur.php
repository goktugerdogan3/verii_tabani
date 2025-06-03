<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'baglanti.php';

// Sipariş oluşturma işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al ve sayısal tiplere dönüştür
    $musteri_id = (int)$_POST['musteri']; // Tam sayıya dönüştür
    $motor_id = (int)$_POST['motor'];   // Tam sayıya dönüştür
    $miktar = (int)$_POST['miktar'];   // Tam sayıya dönüştür
    $birim_fiyat = (float)$_POST['birim_fiyat']; // Ondalıklı sayıya dönüştür

    // datetime formatı için tarih ve saati al, date formatı için sadece tarihi alıyoruz
    // phpMyAdmin'deki 'Tarih' sütunu 'date' tipinde görünüyor.
    // Bu nedenle sadece Y-m-d formatını kullanmalıyız.
    $siparis_tarihi = date("Y-m-d"); // Güncel tarih (sadece YYYY-MM-DD formatında)

    // Miktar ve birim fiyatın sayısal olduğundan emin olduk, şimdi çarpabiliriz
    $tutar = $miktar * $birim_fiyat;

    // Siparişi 'siparis' tablosuna ekle
    // PHPMyAdmin yapısına göre 'Musteri_ID' ve 'Tarih' sütun adlarını kullanıyoruz.
    // 'Toplam_Tutar' sütununu şimdilik boş bırakıyoruz (NULL),
    // isterseniz sipariş detayları eklendikten sonra güncelleyebilirsiniz.
    $sqlSiparis = "INSERT INTO siparis (Musteri_ID, Tarih) VALUES (?, ?)";
    $stmtSiparis = $baglanti->prepare($sqlSiparis);
    // 'is' yerine 'id' kullanıyoruz çünkü Musteri_ID integer ('i'), Tarih date ('s' string veya 'd' MySQL date tipi için ama bind_param 's' ile çalışır)
    // MySQL date tipi genellikle string ('s') olarak bağlanır
    $stmtSiparis->bind_param("is", $musteri_id, $siparis_tarihi);


    if ($stmtSiparis->execute()) {
        $siparis_id = $baglanti->insert_id; // Yeni eklenen siparişin ID'sini al

        // Sipariş detayını 'siparis_detaylari' tablosuna ekle
        // phpMyAdmin yapısına göre 'Siparis_ID', 'Motor_ID', 'Miktar', 'Tutar' sütun adlarını kullanıyoruz.
        $sqlDetay = "INSERT INTO siparis_detaylari (Siparis_ID, Motor_ID, Miktar, Tutar) VALUES (?, ?, ?, ?)";
        $stmtDetay = $baglanti->prepare($sqlDetay);
        // Tutar burada satır toplamı olacak. 'd' double/decimal için doğru tip.
        $stmtDetay->bind_param("iiid", $siparis_id, $motor_id, $miktar, $tutar); // 'i' integer, 'i' integer, 'i' integer, 'd' double/decimal

        if ($stmtDetay->execute()) {
            // Stok miktarını güncelle
            // phpMyAdmin yapısına göre 'Stok_Miktarı' sütun adını kullanıyoruz.
            $sqlUpdateStok = "UPDATE motor SET Stok_Miktarı = Stok_Miktarı - ? WHERE Motor_ID = ?";
            $stmtUpdateStok = $baglanti->prepare($sqlUpdateStok);
            // Miktar ve Motor_ID integer'dır
            $stmtUpdateStok->bind_param("ii", $miktar, $motor_id);

            if ($stmtUpdateStok->execute()) {
                 $mesaj = "Sipariş başarıyla oluşturuldu ve stok güncellendi. Sipariş ID: " . $siparis_id;
                 $mesaj_tipi = "success"; // Başarı mesajı için sınıf
            } else {
                 $mesaj = "Sipariş oluşturuldu ancak stok güncellenemedi: " . $stmtUpdateStok->error;
                 $mesaj_tipi = "warning"; // Uyarı mesajı için sınıf
            }

        } else {
            // Detay eklenemezse, siparişi geri al (isteğe bağlı ama iyi bir pratik)
            // SQL Injection riskini azaltmak için yine prepared statement kullanmak daha iyi olur
            $sqlDeleteSiparis = "DELETE FROM siparis WHERE Siparis_ID = ?";
            $stmtDeleteSiparis = $baglanti->prepare($sqlDeleteSiparis);
            $stmtDeleteSiparis->bind_param("i", $siparis_id);
            $stmtDeleteSiparis->execute();
            $stmtDeleteSiparis->close(); // Statement'ı kapat

            $mesaj = "Sipariş detayı eklenirken hata oluştu. Sipariş geri alındı: " . $stmtDetay->error;
            $mesaj_tipi = "danger"; // Hata mesajı için sınıf
        }
    } else {
        $mesaj = "Sipariş oluşturulurken hata oluştu: " . $stmtSiparis->error;
        $mesaj_tipi = "danger"; // Hata mesajı için sınıf
    }

    // Statement'ları kapat
    $stmtSiparis->close();
    if (isset($stmtDetay)) $stmtDetay->close();
    if (isset($stmtUpdateStok)) $stmtUpdateStok->close();
    // $stmtDeleteSiparis zaten hata durumunda kapatılıyor

    // Veritabanı bağlantısını kapatmadan önce statement'ların kapatılması önemlidir.
    // Bağlantıyı en sona taşıyalım veya işlem bittikten sonra kapatılmasını sağlayalım.
    // Şu anki yerinde de çalışır ama best practice olarak sona taşınabilir.
}

// Form için müşteri ve motor verilerini çek
$sqlMusteri = "SELECT musteri_id, ad, soyad FROM musteri ORDER BY ad ASC";
$resultMusteri = $baglanti->query($sqlMusteri);

// PHPMyAdmin yapısına göre 'Stok_Miktarı' sütun adını kullanıyoruz ve 'Stok' olarak alias (takma ad) veriyoruz
$sqlMotor = "SELECT Motor_ID, Marka, Model, Fiyat, Stok_Miktarı AS Stok FROM motor ORDER BY Marka ASC";
$resultMotor = $baglanti->query($sqlMotor);

// Sayfanın sonunda bağlantıyı kapatmak daha uygun olabilir
$baglanti->close();

?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yeni Sipariş Oluştur</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.container { margin-top: 30px; }
</style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Yeni Sipariş Oluştur</h2>

    <?php if (isset($mesaj)): ?>
        <div class="alert alert-<?php echo $mesaj_tipi; ?> alert-dismissible fade show" role="alert">
            <?php echo $mesaj; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="mb-3">
            <label for="musteri" class="form-label">Müşteri Seçin:</label>
            <select class="form-select" id="musteri" name="musteri" required>
                <option value="">Müşteri Seçiniz</option>
                <?php
                if ($resultMusteri && $resultMusteri->num_rows > 0) { // result kontrolü eklendi
                    while($rowMusteri = $resultMusteri->fetch_assoc()) {
                        echo "<option value='" . $rowMusteri['musteri_id'] . "'>" . htmlspecialchars($rowMusteri['ad'] . ' ' . $rowMusteri['soyad']) . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>Müşteri bulunamadı.</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="motor" class="form-label">Motor Seçin:</label>
            <select class="form-select" id="motor" name="motor" required>
                <option value="">Motor Seçiniz</option>
                 <?php
                if ($resultMotor && $resultMotor->num_rows > 0) { // result kontrolü eklendi
                    while($rowMotor = $resultMotor->fetch_assoc()) {
                         // Option'a value olarak Motor_ID, içeriği olarak Marka ve Model veriyoruz
                         // Data attribute olarak fiyat ve stok ekliyoruz (JavaScript ile erişmek için)
                         // Stok bilgisi çekilirken Stok_Miktarı AS Stok yaptığımız için $rowMotor['Stok'] kullanabiliriz.
                        echo "<option value='" . $rowMotor['Motor_ID'] . "' data-fiyat='" . $rowMotor['Fiyat'] . "' data-stok='" . $rowMotor['Stok'] . "'>" . htmlspecialchars($rowMotor['Marka'] . ' ' . $rowMotor['Model'] . ' (Stok: ' . $rowMotor['Stok'] . ')') . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>Motor bulunamadı.</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="miktar" class="form-label">Miktar:</label>
            <input type="number" class="form-control" id="miktar" name="miktar" min="1" required>
            <!-- Stok miktarını göstermek için boş bir span -->
            <small class="form-text text-muted" id="stokBilgisi"></small>
            <!-- Seçilen motorun birim fiyatını gizli inputta saklayacağız -->
            <input type="hidden" id="birim_fiyat" name="birim_fiyat">
        </div>

        <!-- JavaScript ile Miktar alanına maksimum stok değerini ve Birim Fiyatı set etme -->
        <script>
            const motorSelect = document.getElementById('motor');
            const miktarInput = document.getElementById('miktar');
            const stokBilgisi = document.getElementById('stokBilgisi');
            const birimFiyatInput = document.getElementById('birim_fiyat');

            motorSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                // data-stok ve data-fiyat string olarak gelir, sayıya dönüştürmek gerekebilir
                const stok = selectedOption.getAttribute('data-stok');
                const fiyat = selectedOption.getAttribute('data-fiyat');

                // Stok bilgisini gösterme ve miktar inputunun max değerini set etme
                if (stok !== null && stok !== "") { // Boş string kontrolü de eklendi
                    stokBilgisi.textContent = 'Maksimum Stok: ' + stok;
                    // Miktar inputunun max değerini integer'a dönüştürerek set et
                    miktarInput.max = parseInt(stok, 10);
                     // Eğer seçilen miktar maksimum stoku aşarsa, miktarı maksimum stoğa eşitle
                    if (parseInt(miktarInput.value, 10) > parseInt(stok, 10)) {
                         miktarInput.value = parseInt(stok, 10);
                    }

                } else {
                    stokBilgisi.textContent = 'Stok bilgisi mevcut değil.'; // Stok yoksa bilgilendirme
                    miktarInput.removeAttribute('max'); // Stok bilgisi yoksa max attribute'u kaldır
                     miktarInput.value = 1; // Stok yoksa veya bilgi gelmezse miktarı 1 yap
                }

                // Birim fiyatı gizli inputa set etme (sayısal formatta)
                if (fiyat !== null && fiyat !== "") { // Boş string kontrolü de eklendi
                    birimFiyatInput.value = parseFloat(fiyat).toFixed(2); // Ondalıklı sayıya dönüştür ve 2 ondalık basamağı ayarla
                } else {
                    birimFiyatInput.value = '0.00'; // Fiyat bilgisi yoksa 0.00 yap
                }
            });

             // Sayfa yüklendiğinde ilk seçili motorun stok ve fiyat bilgisini göstermek için
             // veya motor seçiliyse başlangıçta bilgiyi yüklemek için
             // Sayfa yüklendiğinde ilk option seçili olabilir (Müşteri Seçiniz, Motor Seçiniz)
             // Bu nedenle, sadece geçerli bir motor seçeneği seçildiyse çalışmasını sağlayalım
             if (motorSelect.value !== "") {
                 const initialSelectedOption = motorSelect.options[motorSelect.selectedIndex];
                 const initialStok = initialSelectedOption.getAttribute('data-stok');
                 const initialFiyat = initialSelectedOption.getAttribute('data-fiyat');

                 if (initialStok !== null && initialStok !== "") {
                     stokBilgisi.textContent = 'Maksimum Stok: ' + initialStok;
                     miktarInput.max = parseInt(initialStok, 10);
                     // Eğer başlangıçta miktar alanı doluysa ve stoku aşıyorsa
                     if (miktarInput.value && parseInt(miktarInput.value, 10) > parseInt(initialStok, 10)) {
                         miktarInput.value = parseInt(initialStok, 10);
                     }
                 } else {
                      stokBilgisi.textContent = 'Stok bilgisi mevcut değil.';
                      miktarInput.removeAttribute('max');
                 }

                 if (initialFiyat !== null && initialFiyat !== "") {
                      birimFiyatInput.value = parseFloat(initialFiyat).toFixed(2);
                 } else {
                      birimFiyatInput.value = '0.00';
                 }
             }


        </script>

        <button type="submit" class="btn btn-primary">Sipariş Oluştur</button>
        <a href="index.php" class="btn btn-secondary">Ana Sayfaya Dön</a>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>