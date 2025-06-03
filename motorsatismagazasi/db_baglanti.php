<?php  
$host = "localhost";  
$kullanici = "root";    // PhpMyAdmin giriş bilgisi  
$sifre = "Erdo3800.";  
$veritabani = "motorsatismagazasi";  

// MySQLi bağlantısı  
$baglanti = new mysqli($host, $kullanici, $sifre, $veritabani);  

// Bağlantıyı kontrol et  
if ($baglanti->connect_error) {  
    die("Bağlantı başarısız: " . $baglanti->connect_error);  
}  

// Bağlantı başarılı  
// İsterseniz buraya ek kodlar ekleyebilirsiniz  
?>  