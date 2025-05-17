<?php
session_start();

// Settings
$width = 120;
$height = 40;
$length = 5;
$font_size = 20;
$font = __DIR__ . '/arial.ttf'; // Make sure you have a TTF font file here or use a system font

// Font existence check
if (!file_exists($font)) {
    header('Content-Type: text/plain');
    die('Font file not found: ' . $font);
}

// Generate random code
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$code = '';
for ($i = 0; $i < $length; $i++) {
    $code .= $chars[rand(0, strlen($chars) - 1)];
}
$_SESSION['captcha_code'] = $code;

// Create image
$image = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($image, 245, 245, 245);
$fg = imagecolorallocate($image, 40, 40, 40);
$noise = imagecolorallocate($image, 180, 180, 180);
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Add noise lines
for ($i = 0; $i < 8; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $noise);
}
// Add noise dots
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noise);
}
// Add text with random angle
for ($i = 0; $i < $length; $i++) {
    $angle = rand(-25, 25);
    $x = 15 + $i * 20;
    $y = rand(28, 36);
    imagettftext($image, $font_size, $angle, $x, $y, $fg, $font, $code[$i]);
}
// Output
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image); 