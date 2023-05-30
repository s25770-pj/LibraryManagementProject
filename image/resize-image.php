<?php
// Ścieżka do oryginalnego pliku PNG
$originalImagePath = 'D:\XAMPP\htdocs\Projects\LibraryManagement\Ksiazki\cartResize.png';

// Wczytaj oryginalny obraz PNG
$originalImage = imagecreatefrompng($originalImagePath);

// Nowe wymiary obrazu
$newWidth = 30;
$newHeight = 30;

// Utwórz nowy obraz o zmniejszonym rozmiarze
$resizedImage = imagescale($originalImage, $newWidth, $newHeight);

// Ustaw przezroczystość (jeśli potrzebne)
imagecolortransparent($resizedImage, imagecolorallocatealpha($resizedImage, 0, 0, 0, 127));

// Ścieżka do zapisanego zmniejszonego obrazu PNG
$resizedImagePath = 'D:\XAMPP\htdocs\Projects\LibraryManagement\Ksiazki\cart.png';

// Zapisz zmniejszony obraz w formacie PNG
imagepng($resizedImage, $resizedImagePath);

// Zwolnij pamięć
imagedestroy($originalImage);
imagedestroy($resizedImage);

?>