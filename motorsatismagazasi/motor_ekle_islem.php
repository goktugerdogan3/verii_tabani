<?php  
include 'db_baglanti.php';  

$Marka = $_POST['Marka'];  
$Model = $_POST['Model'];  
$Fiyat = $_POST['Fiyat'];  
$Yıl = $_POST['yıl']; // formdaki input name "yıl"  
$Stok_Miktarı = $_POST['Stok_Miktarı'] ?? 0; // stok alanınızın adı "Stok_Miktarı"  

// Tüm alanların dolu olması  
if (!$Marka || !$Model || !$Fiyat || !$Yıl) {  
    die("Lütfen tüm alanları doldurun.");  
}  

// Güvenlik önlemi  
$Marka = $baglanti->real_escape_string($Marka);  
$Model = $baglanti->real_escape_string($Model);  
$Fiyat = floatval($Fiyat);  
$Yil = intval($Yıl);  
$Stok_Miktarı = intval($Stok_Miktarı);  

// SQL  
$sql = "INSERT INTO motor (Marka, Model, Fiyat, Yıl, Stok_Miktarı) VALUES ('$Marka', '$Model', '$Fiyat', '$Yıl', '$Stok_Miktarı')";  

if ($baglanti->query($sql) === TRUE) {  
    echo "<div class='alert alert-success text-center'>Motor başarıyla eklendi!</div>";  
} else {  
    echo "<div class='alert alert-danger'>Hata: " . $baglanti->error . "</div>";  
}  
?>  