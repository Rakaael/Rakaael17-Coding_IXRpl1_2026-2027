<?php
// cara membuat array yang detail
$angka = [
    0 => 10,
    1 => 11,
    2 => 12,
];

$angka =[10, 11, 12];

$i = 0;
while ($i < count($angka)) {
    echo "Angka $i : " . $angka[$i] . "<br>";
    $i++;
}

?>