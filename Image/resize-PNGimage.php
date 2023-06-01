<?php
// Ścieżka do oryginalnego pliku PNG
$originalImagePath = 'D:\XAMPP\htdocs\Projects\LibraryManagement\Okladki\W pustyni i w puszczyr.jpg';

// Wczytaj oryginalny obraz PNG
$originalImage = imagecreatefrompng($originalImagePath);

// Nowe wymiary obrazu
$newWidth = 50;
$newHeight = 100;

// Utwórz nowy obraz o zmniejszonym rozmiarze
$resizedImage = imagescale($originalImage, $newWidth, $newHeight);

// Ustaw przezroczystość (jeśli potrzebne)
imagecolortransparent($resizedImage, imagecolorallocatealpha($resizedImage, 0, 0, 0, 127));

// Ścieżka do zapisanego zmniejszonego obrazu PNG
$resizedImagePath = 'D:\XAMPP\htdocs\Projects\LibraryManagement\Okladki\W pustyni i w puszczy.jpg';

// Zapisz zmniejszony obraz w formacie PNG
imagepng($resizedImage, $resizedImagePath);

// Zwolnij pamięć
imagedestroy($originalImage);
imagedestroy($resizedImage);

?>