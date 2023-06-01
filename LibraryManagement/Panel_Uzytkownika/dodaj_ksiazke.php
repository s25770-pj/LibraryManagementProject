<?php

session_start();

if (!isset($_SESSION['zalogowany']))
{
	header('Location: index.php');
	exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administratora</title>

    <link rel="stylesheet" href="../Style/doladuj_saldo.css">

</head>
<body>

<div id = "tlo"></div>

<div id = "pakiety">

    <?php

    echo '<p><strong>Dodaj książkę do oferty księgarni: </strong></p>';

    echo '<form method = "POST">';

    echo 'Tytuł: <input type = "text" name = "tytul" class = "dodaj_ksiazke"> <br /><br />';
    echo 'Autor: <input type = "text" name = "autor" class = "dodaj_ksiazke"> <br /><br />';
    echo 'Gatunek: <input type = "text" name = "gatunek" class = "dodaj_ksiazke"> <br /><br />';
    echo 'Rodzaj: <select name = "rodzaj" class = "dodaj_ksiazke">';
    echo '<option value = "Książka"> Książka </option>';
    echo '<option value = "Audio Book"> Audio Book </option>';
    echo '</select><br /><br />';
    echo 'Cena: <input type = "number" id = "no-spinners" name = "cena" class = "dodaj_ksiazke"> <br /><br />';
    echo 'Opis: <br /> <textarea name="opis" cols="35" rows="5" class = "dodaj_ksiazke">Tu wpisz tekst który pojawi się domyślnie</textarea> <br />';
    echo '<input type = "submit" value = "Dodaj ksiazke" class = "przycisk"> <br /><br />';
    echo '</form>';
    echo '<form action = "../Panel_Uzytkownika/panel_uzytkownika.php">';
    echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';
    echo '</form>';

    if(isset($_POST['rodzaj'])){

    $buttonOut  = $_POST['rodzaj'];

    }

    require_once "../Laczenie_Z_Baza/connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_errno) {
        exit("Błąd połączenia z bazą danych: ". $polaczenie->connect_errno);
    }

    if(isset($_POST['rodzaj'])) {
        
        //Ustawianie id w bazie danych po ilosci recordow

        $idKsiazki = "SELECT COUNT(*) as total FROM inwentarz";
        $res = $polaczenie->query($idKsiazki);
        $row = $res->fetch_assoc();
        $totalRecords = $row['total'];

        $id = $totalRecords + 1;
        $tytul = $_POST['tytul'];
        $autor = $_POST['autor'];
        $gatunek = $_POST['gatunek'];
        $rodzaj = $_POST['rodzaj'];
        $cena = $_POST['cena'];
        $opis = $_POST['opis'];
        
        //Sprawdzenie, czy isnieje książka o takiej nazwie

        $query = "SELECT * FROM inwentarz WHERE tytul = ?";
        $stmt = $polaczenie->prepare($query);
        $stmt->bind_param("s", $tytul);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            echo "Książka już istnieje w bazie danych.";

        } else {

            //Dodanie książki do księgarni

            if (empty($tytul) || empty($autor) || empty($gatunek) || empty($rodzaj) || empty($cena) || empty($opis)) {
                    echo "Wszystkie pola formularza są wymagane.";
            } else {

            $insertQuery = "INSERT INTO inwentarz (id, tytul, autor, gatunek, rodzaj, cena, opis) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $polaczenie->prepare($insertQuery);
            $insertStmt->bind_param("ssssss", $tytul, $autor, $gatunek, $rodzaj, $cena, $opis);

            if($insertStmt->execute()) {
                echo "Książka została dodana do oferty księgarni.";
            } else {
                echo "Błąd zapytania: " . $polaczenie->error;
            }

            $res->close();

            $insertStmt->close();

            }

        $stmt->close();
        
        }
    }

    $polaczenie->close();

    ?>

    </form>

</div>

</body>

</html>