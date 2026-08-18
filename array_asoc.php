<?php

require "coba_while.php";  //materi modular

// include
// requare_once
// iterate associative array and print student data using while loop
$a = 0;
$count = count($NamaSiswa);
while ($a < $count) {
    echo "Nomor " . ($a + 1) . "<br>";
    echo "Nama Siswa: " . $NamaSiswa[$a]['nama'] . "<br>";
    echo "Umur: " . $NamaSiswa[$a]['umur'] . "<br>";
    echo "Alamat: " . $NamaSiswa[$a]['alamat'] . "<br>";
    echo "<br>";
    $a++;
}