<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>URL Iklan</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">    
<link rel="icon" href="https://www.medialova.com/assets/images/favicon.ico">    
  </head>
  
<style>
body{
  margin: 0;
  padding: 2;
  font-family: sans-serif;
  background: url(https://medialova.com/short/Admin/bg.jpg) no-repeat;
  background-size: cover;
}    
</style> 

<style>
.iklan{
  width: 280px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
.teks{
  width: 280px;
  position: absolute;
  top: 60%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>

  
  <body><br><center>
    <form class="iklan" action="" method="post">
      <input type="text" name="longurl" placeholder="URL Iklan">
      <button type="submit" name="submit">Kirim</button>
    </form></center>
  </body>
</html>

<div class='short2'><center>
<?php
if(isset($_POST['submit'])) {

  // Menyertakan file konfigurasi database
  require_once 'dbConfig.php';

  // Menyertakan file library Shortener URL
  require_once 'Shortener.class.php';

  // Menginisialisasi class Shortener dan meneruskan ke PDO
  $shortener = new Shortener($db);

  // URL asli
  $longURL = $_POST['longurl'];;

  // Prefix dari short URL
  $shortURL_Prefix = 'https://medialova.com/iklan/s/'; // dengan URL rewrite
  //$shortURL_Prefix = 'https://medialova.com/iklan/s/?c='; // tanpa URL rewrite

  try{
      // Mendapatkan URL dengan short code
      $shortCode = $shortener->urlToShortCode($longURL);

      // Membuat short URL
      $shortURL = $shortURL_Prefix.$shortCode;

      // Menampilkan short URL
      echo 'Short URL: '.$shortURL;
  }catch(Exception $e){
      // Menampilkan error
      echo $e->getMessage();
  }

}
?>
</center></div>

<br><br>
<center><div class="teks">Gunakan Short URL Untuk Iklan.</div></center>
