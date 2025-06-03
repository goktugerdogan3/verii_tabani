<?php  
include 'baglanti.php';   

$sql = "SELECT * FROM musteri";  
$result = $baglanti->query($sql);  
?>  

<!DOCTYPE html>  
<html lang="tr">  
<head>  
<meta charset="UTF-8" />  
<title>Müşteri Listesi</title>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />  
</head>  
<body>  
<div class="container mt-5">  
    <h2>Müşteri Listesi</h2>  
    <a href="musteri_ekle.php" class="btn btn-success mb-3">Müşteri Ekle</a>  
    <table class="table table-striped table-bordered">  
        <thead>  
            <tr>  
                <th>ID</th>  
                <th>Ad</th>  
                <th>Soyad</th>  
                <th>Telefon</th>  
                <th>Email</th>  
            </tr>  
        </thead>  
        <tbody>  
            <?php  
            if ($result && $result->num_rows > 0) {  
                while($row = $result->fetch_assoc()) {  
                    echo "<tr>  
                        <td>{$row['Musteri_ID']}</td>  
                        <td>{$row['Ad']}</td>  
                        <td>{$row['Soyad']}</td>  
                        <td>{$row['Telefon']}</td>  
                        <td>{$row['Email']}</td>  
                    </tr>";  
                }  
            } else {  
                echo "<tr><td colspan='5' class='text-center'>Kayıt Yok</td></tr>";  
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