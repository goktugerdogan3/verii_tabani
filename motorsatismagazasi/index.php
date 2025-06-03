<!DOCTYPE html>  
<html lang="tr">  
<head>  
<meta charset="UTF-8" />  
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<title>Motor Satış Paneli</title>  
<!-- Bootstrap CSS -->  
<link  
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  
  rel="stylesheet"  
/>  
<!-- Google Fonts -->  
<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet" />  
<style>  
  body {  
    margin: 0;  
    padding: 0;  
    height: 100vh;  
    overflow: hidden;  
    font-family: 'Oswald', sans-serif;  

    /* Arka plan hareketli resim */  
    background-image: url('motor.jpg'); /* Masaüstünde bu dosyayı uygun yere yerleştir */  
    background-size: cover;  
    background-position: center;  
    background-repeat: no-repeat;  
    animation: floatBackground 20s linear infinite;  
  }  

  @keyframes floatBackground {  
    0% {  
      background-position: center;  
    }  
    50% {  
      background-position: center top;  
    }  
    100% {  
      background-position: center;  
    }  
  }  

  .overlay {  
    position: relative;  
    z-index: 2;  
    background-color: rgba(0,0,0,0.4);  
    padding: 20px;  
    min-height: 100%;  
  }  

  .header-section {  
    padding: 50px 20px;  
    background-color: rgba(52, 58, 64, 0.8);  
    border-radius: 10px;  
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);  
    margin-bottom: 30px;  
  }  

  .header-section h1 {  
    font-size: 3rem;  
    margin-bottom: 20px;  
  }  

  .cards-container {  
    margin-top: 40px;  
  }  

  .card {  
    transition: transform 0.3s, box-shadow 0.3s;  
    background-color: rgba(255,255,255,0.8);  
    height: 100%; /* Kartların eşit yükseklikte olması için */  
  }  

  .card:hover {  
    transform: translateY(-10px);  
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);  
  }  

  /* Büyük motor resmi */  
  .large-motor-img {  
    width: 100%;  
    max-height: 400px;  
    object-fit: cover;  
    border-radius: 10px;  
    margin-bottom: 40px;  
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);  
  }  
</style>  
</head>  
<body>  

<div class="overlay d-flex flex-column justify-content-center align-items-center">  
  <div class="container header-section text-center">  
    <h1>Motor Satış Yönetim Paneli</h1>  
    <p class="lead">Dünyanın en güzel motorlar burada! Güç ve şıklığın birleştiği adres.</p>  
    <div class="mt-4">  
      <a href="motor_listele.php" class="btn btn-primary btn-lg mx-2">Motorları Listele</a>  
      <a href="motor_ekle.php" class="btn btn-success btn-lg mx-2">Yeni Motor Ekle</a>  
      <a href="musteri_ekle.php" class="btn btn-info btn-lg mx-2">Müşteri Ekle</a>  
      <a href="musteriler_listele.php" class="btn btn-warning btn-lg mx-2">Müşteri Listesi</a>  
      <!-- Yeni eklenen buton -->
<a href="siparis_listele.php" class="btn btn-secondary btn-lg mx-2">Siparişler Listesi</a>
<a href="siparis_olustur.php" class="btn btn-success btn-lg mx-2">Yeni Sipariş Oluştur</a>
    </div>  
  </div>  

  <!-- Büyük motor resmi -->  
  <img src="img/motor.jpg" alt="Motor" class="large-motor-img" />  
  <!-- Motorlar hakkında kısa bilgiler veya reklamlar -->  
  <div class="container cards-container text-center">  
    <div class="row g-4">  
      <div class="col-md-4">  
        <div class="card p-3 h-100">  
          <img src="https://images.unsplash.com/photo-1549924231-f129b911e442?ixlib=rb-" alt="Motor Resmi" class="card-img-top mb-3" />  
          <h5>En Yeni Modeller</h5>  
          <p>Piyasaya sürülen en güncel ve performanslı motorları keşfedin.</p>  
        </div>  
      </div>  
      <div class="col-md-4">  
        <div class="card p-3 h-100">  
          <img src="https://images.unsplash.com/photo-1558981408-d0326ad7094c?ixlib=rb-" alt="Motor Resmi" class="card-img-top mb-3" />  
          <h5>Özel Fırsatlar</h5>  
          <p>Kaçırılmayacak indirimler ve kampanyalardan haberdar olun.</p>  
        </div>  
      </div>  
      <div class="col-md-4">  
        <div class="card p-3 h-100">  
          <img src="https://images.unsplash.com/photo-1506748686214-e9da3d0c60e5?ixlib=rb-" alt="Motor Resmi" class="card-img-top mb-3" />  
          <h5>Garanti ve Servis</h5>  
          <p>Güvenilir satış sonrası hizmet ve garanti seçenekleri.</p>  
        </div>  
      </div>  
    </div>  
  </div>  
</div>  

<!-- Bootstrap JS (isteğe bağlı) -->  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  

</body>  
</html>