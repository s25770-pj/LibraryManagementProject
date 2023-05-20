<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}


require_once '../Laczenie_Z_Baza/connect.php';

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    echo "Błąd połączenia z bazą danych: " . $polaczenie->connect_error;
    exit();
}

if(isset($_POST['id_ksiazki'])){

    $id_ksiazki = $_POST['id_ksiazki'];
    $id_uzytkownika = $_SESSION['id'];
    $aktualna_data_czas = date('Y-m-d H:i:s');

    echo 'id ksiazki: ' . $id_ksiazki . '<br />';
    echo 'id uzytkownika: ' . $id_uzytkownika . '<br />';
    echo 'Aktualna data: ' . $aktualna_data_czas . '<br />';

        
        $query = "INSERT INTO wypozyczenia VALUES (NULL ,? ,? ,now() , now() + INTERVAL 7 DAY)";

        $stmt = $polaczenie->prepare($query);
        $stmt->bind_param("ii", $id_uzytkownika, $id_ksiazki);

    if ($stmt->execute()) {

        echo "Rekord został dodany do bazy poprawnie. <br />";

    } else {

        echo "Błąd podczas dodawania rekordu do bazy danych. <br />";

    }

}
$stmt->close();
$polaczenie->close();

unset($_POST['id_ksiazki']);

if(isset($_POST['id_ksiazki'])){
    echo 'jest ustawione';
} else {{
    echo 'nie jest ustawione';
}}

?>