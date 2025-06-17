<?php
// Create a placeholder image for missing thumbnails
$width = 400;
$height = 300;
$image = imagecreatetruecolor($width, $height);

// Colors
$bg = imagecolorallocate($image, 242, 242, 242);
$textColor = imagecolorallocate($image, 120, 120, 120);
$borderColor = imagecolorallocate($image, 220, 220, 220);

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Add a border
imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);

// Center text
$text = "No Image";
$font = 5; // Built-in font (1-5)
$textWidth = imagefontwidth($font) * strlen($text);
$textHeight = imagefontheight($font);
$x = ($width - $textWidth) / 2;
$y = ($height - $textHeight) / 2;

// Draw text
imagestring($image, $font, $x, $y, $text, $textColor);

// Save the image
$outputFile = __DIR__ . '/no-image.jpg';
imagejpeg($image, $outputFile, 90);
imagedestroy($image);

echo "Placeholder image created at: $outputFile"; 