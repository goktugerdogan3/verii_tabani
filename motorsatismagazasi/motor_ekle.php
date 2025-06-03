<!DOCTYPE html>  
<html lang="tr">  
<head>  
  <meta charset="UTF-8" />  
  <title>Motor Ekle</title>  
  <!-- Bootstrap CSS -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
</head>  
<body>  

<div class="container my-5">  
  <h2 class="text-center mb-4">Motor Ekle</h2>  
  
  <!-- Motor Ekleme Formu -->  
  <form action="motor_ekle_islem.php" method="POST" class="mx-auto" style="max-width:500px;">  
    <div class="mb-3">  
      <label for="marka" class="form-label">Marka</label>  
      <input type="text" class="form-control" id="marka" name="Marka" required>  
    </div>  
    <div class="mb-3">  
      <label for="model" class="form-label">Model</label>  
      <input type="text" class="form-control" id="model" name="Model" required>  
    </div>  
    <div class="mb-3">  
      <label for="fiyat" class="form-label">Fiyat</label>  
      <input type="number" class="form-control" id="fiyat" name="Fiyat" required>  
    </div>  
    <div class="mb-3">  
      <label for="yil" class="form-label">Yıl</label>  
      <input type="number" class="form-control" id="yil" name="yıl" required>  
    </div>  
    <div class="mb-3">  
      <label for="stok_miktari" class="form-label">Stok Miktarı</label>  
      <input type="number" class="form-control" id="stok_miktari" name="Stok_Miktarı" value="1" required>  
    </div>  
    <!-- Burada "Motor Ekle" butonu -->  
    <button type="submit" class="btn btn-primary w-100">Motor Ekle</button>  
  </form>  

  <!-- Alternatif olarak, tıklanabilir yazı ile buton -->  
  <p class="text-center mt-3">  
    <a href="motor_ekle.php" class="btn btn-link">Motor Ekle (tıklanabilir yazı)</a>  
  </p>  

</div>  

<!-- Bootstrap JS -->  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>  