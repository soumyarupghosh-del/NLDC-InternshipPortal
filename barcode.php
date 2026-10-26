<?php
// ================================
// SIMPLE & SAFE BARCODE (CODE39)
// ================================

// ---- CHECK GD ----
if (!extension_loaded('gd')) {
    http_response_code(500);
    exit('GD not enabled');
}

// ---- INPUT ----
$text = isset($_GET['text']) ? $_GET['text'] : '0';
$text = strtoupper($text);
$text = preg_replace('/[^A-Z0-9\-\. ]/', '', $text);
if ($text === '') {
    $text = '0';
}

$size = isset($_GET['size']) ? (int)$_GET['size'] : 50;
if ($size < 20 || $size > 150) {
    $size = 50;
}

$print = (isset($_GET['print']) && $_GET['print'] === 'true');

// ---- CODE39 MAP ----
$code39 = [
    "0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111",
    "4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212",
    "8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112",
    "C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111",
    "G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211",
    "K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122",
    "O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221",
    "S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112",
    "W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111",
    "-"=>"121111212","."=>"221111211"," "=>"122111211","*"=>"121121211"
];

// ---- ADD START/STOP ----
$text = '*' . $text . '*';

// ---- CALCULATE WIDTH ----
$width = 20;
foreach (str_split($text) as $c) {
    $width += strlen($code39[$c]) * 2;
}

// ---- CREATE IMAGE ----
$height = $size + ($print ? 20 : 0);
$image = imagecreate($width, $height);

$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $white);

// ---- DRAW BARS ----
$x = 10;
foreach (str_split($text) as $c) {
    foreach (str_split($code39[$c]) as $bar) {
        if ($bar === '1') {
            imagefilledrectangle($image, $x, 0, $x + 2, $size, $black);
        }
        $x += 2;
    }
    $x += 2;
}

// ---- PRINT TEXT ----
if ($print) {
    imagestring($image, 4, 10, $size + 2, trim($text, '*'), $black);
}

// ---- OUTPUT ----
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
exit;
