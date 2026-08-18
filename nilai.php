<?php
$nilai = -12;

switch (true) {
    case ($nilai < 0 || $nilai > 100):
        echo "Status tidak valid";
        break;
    case ($nilai >= 90):
        echo "Nilai A";
        break;
    case ($nilai >= 80):
        echo "Nilai B";
        break;
    case ($nilai >= 70):
        echo "Nilai C";
        break;
    case ($nilai >= 60):
        echo "Nilai D";
        break;
    default:
        echo "Nilai E";
}

?>