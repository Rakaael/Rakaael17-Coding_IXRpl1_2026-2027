<?php

$hari = "kamis";

//if ($hari == "senin") {
   // echo "hari".$hari."<br>";
//echo "seragam : putih abu";
//} else if ($hari == "selasa") {
  //  echo "hari".$hari."<br>";
    //echo "seragam : putih abu";
//} else if ($hari == "rabu") {
  //  echo "hari".$hari."<br>";
    //echo "seragam : almet";
//} else if ($hari == "kamis") {
  //  echo "hari".$hari."<br>" ;
    //echo "seragam : baju jurusan";
//} else if ($hari == "jumat") {
  //  echo "hari".$hari."<br>";
    //echo "seragam : pramuka";
//} 





switch ($hari) {
    case 'senin':
        echo "hari: " . $hari . "<br>";
        echo "seragam : putih abu";
        break;
    case 'selasa' || 'kamis':
        echo "hari: " . $hari . "<br>";
        echo "seragam : baju jurusan";
        break;
    case 'rabu':
        echo "hari: " . $hari . "<br>";
        echo "seragam : almet";
        break;
    case 'kamis':
        echo "hari: " . $hari . "<br>";
        echo "seragam : baju jurusan";
        break;
    case 'jumat':
        echo "hari: " . $hari . "<br>";
        echo "seragam : pramuka";
        break;
    default:
        echo "Hari tidak valid";
}

