<?php
// Ścieżka do oryginalnego zdjęcia
$sciezkaZdjecia = 'D:\XAMPP\htdocs\Projects\LibraryManagement\Okladki\Aluszta w dzienr.jpg';

// Nowe wymiary dla zdjęcia (np. szerokość 500px, zachowanie proporcji)
$nowaSzerokosc = 120;
$stosunekProporcji = getimagesize($sciezkaZdjecia)[0] / getimagesize($sciezkaZdjecia)[1];
$nowaWysokosc = round($nowaSzerokosc / $stosunekProporcji);

// Otwórz oryginalne zdjęcie
$oryginalneZdjecie = imagecreatefromjpeg($sciezkaZdjecia);

// Utwórz nowe puste zdjęcie o zadanych wymiarach
$noweZdjecie = imagecreatetruecolor($nowaSzerokosc, $nowaWysokosc);

// Skopiuj i zmień rozmiar oryginalnego zdjęcia do nowego zdjęcia
imagecopyresampled($noweZdjecie, $oryginalneZdjecie, 0, 0, 0, 0, $nowaSzerokosc, $nowaWysokosc, imagesx($oryginalneZdjecie), imagesy($oryginalneZdjecie));

// Ścieżka do zapisanego zmienionego zdjęcia
$sciezkaNowegoZdjecia = 'D:\XAMPP\htdocs\Projects\LibraryManagement\Okladki\Aluszta w dzien.jpg';

// Zapisz nowe zdjęcie w formacie JPG (możesz użyć też imagepng() lub imagegif() dla innych formatów)
imagejpeg($noweZdjecie, $sciezkaNowegoZdjecia, 90); // 90 to jakość obrazu (0-100)

// Zwolnij pamięć
imagedestroy($oryginalneZdjecie);
imagedestroy($noweZdjecie);

echo 'Zdjęcie zostało zmienione i zapisane w nowym rozmiarze.';
?>