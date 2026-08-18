<?php

include_once "coba_while.php";  

// tampilkan nama siswa yang berumur 17 tahun

$a = 0;
while ($a < count($NamaSiswa)) {
    if ($NamaSiswa[$a]['umur'] == 17) {
        echo "Nama Siswa: " . $NamaSiswa[$a]['nama'] . "<br>";
        echo "Umur: " . $NamaSiswa[$a]['umur'] . "<br>";
        echo "Alamat: " . $NamaSiswa[$a]['alamat'] . "<br>";
        echo "<br>";     
    }
    $a++;  
}