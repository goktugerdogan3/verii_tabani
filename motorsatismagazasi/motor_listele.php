<!DOCTYPE html>  
<html lang="tr">  
<head>  
  <meta charset="UTF-8" />  
  <title>Motor Listesi</title>  
  <!-- Bootstrap CSS -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />  
</head>  
<body>  

<div class="container my-5">  
  <h2 class="text-center mb-4">Motor Listesi</h2>  

  <!-- Listeleme Tablosu -->  
  <table class="table table-striped table-bordered table-hover align-middle" style="width:100%; max-width:1000px; margin:auto;">  
    <thead class="table-dark">  
      <tr>  
        <th scope="col">ID</th>  
        <th scope="col">Marka</th>  
        <th scope="col">Model</th>  
        <th scope="col">Fiyat</th>  
        <th scope="col">İşlem</th> <!-- Güncelle butonu için yeni sütun -->  
      </tr>  
    </thead>  
    <tbody>  
      <?php  
      // Bağlantıyı dahil et  
      include 'db_baglanti.php';  

      // Motorları getir  
      $result = $baglanti->query("SELECT * FROM motor");  
      if ($result && $result->num_rows > 0) {  
        while ($row = $result->fetch_assoc()) {  
          echo "<tr>  
                  <td>{$row['Motor_ID']}</td>  
                  <td>{$row['Marka']}</td>  
                  <td>{$row['Model']}</td>  
                  <td>{$row['Fiyat']}</td>  
                  <td>  
                    <a href='motor_guncelle.php?Motor_ID={$row['Motor_ID']}' class='btn btn-primary btn-sm'>Güncelle</a>  
                  </td>  
                </tr>";  
        }  
      } else {  
        echo "<tr><td colspan='5' class='text-center'>Motor bulunamadı</td></tr>";  
      }  
      ?>  
    </tbody>  
  </table>  
        <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Ana Sayfaya Dön</a>
    </div>
</div>  

<!-- Bootstrap JS (isteğe bağlı) -->  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>  