<?php
$chiffre1 = 6;
$chiffre2 = 2;

echo 'Ma fonction : ' . modulo($chiffre1, $chiffre2) . '<br/>';
echo 'Mod : ' . $chiffre1 % $chiffre2;

function modulo($nombre1, $nombre2){
    $max = $nombre1;
    for($i = $nombre2; $i <= $nombre1; $i += $nombre2){
        $max = $i;
    }

    $ret = $nombre1 - $max;
    return $ret;
}
?>
