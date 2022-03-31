<?php
// Menyertakan file konfigurasi database
require_once '../dbConfig.php';

// Menyertakan file library Shortener URL
require_once '../Shortener.class.php';

// Menginisialisasi class Shortener dan meneruskan ke PDO
$shortener = new Shortener($db);

// Mengambil short code URL
$shortCode = $_GET["c"];

try{
    // Mendapatkan URL dengan short code
    $url = $shortener->shortCodeToUrl($shortCode);

    // Mengalihkan ke URL asli
    header("Location: ".$url);
    exit;
}catch(Exception $e){
    // Menampilkan error
    echo $e->getMessage();
}
