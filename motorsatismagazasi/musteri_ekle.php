<?php  
include 'baglanti.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $ad = $_POST['ad'];  
    $soyad = $_POST['soyad'];  
    $telefon = $_POST['telefon'];  
    $email = $_POST['email'];  

    $sql = "INSERT INTO musteri (ad, soyad, telefon, email) VALUES ('$ad', '$soyad', '$telefon', '$email')";  
    if ($baglanti->query($sql) === TRUE) {  
        header("Location: musteriler_listele.php");  
        exit;  
    } else {  
        echo "<div class='alert alert-danger'>Hata: " . $baglanti->error . "</div>";  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="tr">  
<head>  
<meta charset="UTF-8" />  
<title>Müşteri Ekle</title>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />  
</head>  
<body>  
<div class="container mt-5">  
    <h2>Müşteri Ekle</h2>  
    <form method="POST" class="mt-4">  
        <div class="mb-3">  
            <label for="ad" class="form-label">Ad</label>  
            <input type="text" class="form-control" id="ad" name="ad" required>  
        </div>  
        <div class="mb-3">  
            <label for="soyad" class="form-label">Soyad</label>  
            <input type="text" class="form-control" id="soyad" name="soyad" required>  
        </div>  
        <div class="mb-3">  
            <label for="telefon" class="form-label">Telefon</label>  
            <input type="text" class="form-control" id="telefon" name="telefon" required>  
        </div>  
        <div class="mb-3">  
            <label for="email" class="form-label">Email</label>  
            <input type="email" class="form-control" id="email" name="email" required>  
        </div>  
        <button type="submit" class="btn btn-primary">Kaydet</button>  
        <a href="musteriler_listele.php" class="btn btn-secondary">Vazgeç</a>  
    </form>  
</div>  
</body>  
</html>  