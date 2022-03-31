<?php
$hostDB     = "localhost";
$usernameDB = "biandjd_urliklan";
$passwordDB = "melovers2020!";
$namaDB     = "biandjd_urliklan";

// membuat koneksi database
try{
    $db = new PDO("mysql:host=$hostDB;dbname=$namaDB", $usernameDB, $passwordDB);
}catch(PDOException $e){
    echo "Koneksi database gagal: " . $e->getMessage();
}
