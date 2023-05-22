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

    <style>
        p {
            font-size: larger;
        }

        select {
            font-family: 'Courier New', Courier, monospace;
            font-size: large;
            font-weight: bold;
        }

        input[type = 'text'] {
            font-family: 'Courier New', Courier, monospace;
            font-size: medium;
            font-weight: bold;
        }

        input[type = 'submit'] {
            font-family: 'Courier New', Courier, monospace;
            font-size: large;
            font-weight: bold;
        }

    </style>

</head>
<body>

<?php

echo '<p><strong>Dodaj książkę do oferty księgarni: </strong></p>';

echo '<form method = "POST">';

echo 'Tytuł: <input type = "text" name = "tytul"> <br /><br />';
echo 'Autor: <input type = "text" name = "autor"> <br /><br />';
echo 'Gatunek: <input type = "text" name = "gatunek"> <br /><br />';
echo 'Rodzaj: <select name = "rodzaj">';
echo '<option value = "Książka"> Książka </option>';
echo '<option value = "Audio Book"> Audio Book </option>';
echo '</select><br /><br />';
echo 'Cena: <input type = "number" name = "cena"> <br /><br />';
echo 'Opis: <br /> <textarea name="opis" cols="35" rows="5">Tu wpisz tekst który pojawi się domyślnie</textarea> <br />';
echo '<input type = "submit" value = "Dodaj ksiazke"> <br /><br />';
echo '</form>';
echo '[ <a href="userpanel.php">Powrót</a> ]</p>';

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
    
</body>
</html>