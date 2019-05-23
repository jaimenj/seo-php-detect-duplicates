<?php

$titulo1 = 'Magento 1: listar todas las alertas por vuelta a stock de producto';
$titulo2 = 'Magento 1: dejar que los clientes se suscriban a alertas de vuelta a stock';

$coincidents = similar_text($titulo2, $titulo1, $percent);

echo 'Tenemos '.$coincidents.' caracteres coincidentes, con un porcentaje de similaridad de '.$percent.'%'.PHP_EOL;

$levenshtein = levenshtein($titulo1, $titulo2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1);

echo 'Tenemos una distancia de Levenshtein entre las dos cadenas de '.$levenshtein.PHP_EOL;

$keySoundex1 = soundex($titulo1);
$keySoundex2 = soundex($titulo2);
echo 'La clave soundex de $titulo1 es: '.$keySoundex1.PHP_EOL
    .'La clave soundex de $titulo2 es: '.$keySoundex2.PHP_EOL;

$keyMetaphone1 = metaphone($titulo1);
$keyMetaphone2 = metaphone($titulo2);
echo 'La clave metaphone de $titulo1 es: '.$keyMetaphone1.PHP_EOL
    .'La clave metaphone de $titulo2 es: '.$keyMetaphone2.PHP_EOL;
