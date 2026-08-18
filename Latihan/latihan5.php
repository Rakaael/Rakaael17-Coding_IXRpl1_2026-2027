<?php
$angka = [
    [21,22,23,24,25],
    [31,32,33,34,35],
    [41,42,43,44,45],
];

$i = 0;
while ($i < count($angka)) {
    echo $angka[$i][$i * 2] . " ";
    $i++;
    echo "<br>";
}
