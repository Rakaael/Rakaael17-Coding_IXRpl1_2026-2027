<?php 
$angka = [
    [21,22,23,24,25],
    [31,32,33,34,35],
    [41,42,43,44,45],
];

$i = 0;
while ($i < count($angka)) {
   for ($j=0; $j < count($angka[$i]); $j++) {
    echo $angka[$i][$j] . " ";
   }
    
    echo "<br>";
    $i = $i + 2;
    echo "<br>";
}