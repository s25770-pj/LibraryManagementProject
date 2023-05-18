<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        p {
            font-size: larger;
        }

        select {
            font-family: 'Courier New', Courier, monospace;
            font-size: large;
            font-weight: bold;
        }

        button {
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
echo 'Rodzaj: <select name = "typksiazki">';
echo '<option value = "1"> Książka </option>';
echo '<option value = "2"> Audio Book </option>';
echo '</select><br /><br />';
echo 'Cena: <input type = "text" name = "cena"> <br /><br />';
echo '<input type = "submit" value = "Dodaj ksiazke"> <br /><br />';
echo '</form>';
echo '[ <a href="ksiegarnia.php">Powrót</a> ]</p>';

if(isset($_POST['typksiazki'])){

$buttonOut  = $_POST['typksiazki'];

echo $buttonOut;

}

?>

</form>
    
</body>
</html>