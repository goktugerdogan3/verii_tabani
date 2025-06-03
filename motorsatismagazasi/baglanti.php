<?php  
$servername = "localhost";  
$username = "root"; // veritabanı kullanıcısı  
$password = "Erdo3800."; // şifre  
$dbname = "motorsatismagazasi"; // veritabanı  

$baglanti = new mysqli($servername, $username, $password, $dbname);  

if ($baglanti->connect_error) {  
    die("Bağlantı hatası: " . $baglanti->connect_error);  
}  
?>  