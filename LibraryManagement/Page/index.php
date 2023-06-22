<?php
require_once '../Includes/path.php';
session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8" />
	<title>Księgarnia internetowa</title>
    <script src="../JS/browser.js"></script>
    <script src="../JS/bgcolor.js"></script>
	<link rel="stylesheet" href="<?php echo $page_css; ?>">

</head>

<body onload="getBGColor()">
    <header>
        <?php require_once $header; ?>
    </header>
    <div class="bgcolor">
    <h1>Kolor tła</h1>
    <input type="color" id="colorInput" onchange="setBGColor()">
    </div>
    <?php
    require_once $database;
    require_once $header;
    ?>

    <main>
        <h1>Dostępne pozycje:</h1>
        <section id="bookResults">
        
        <section class="searching"></section>
        
        </section>

        <?php
        if (isset($_SESSION['login'])) {
            $connection->close();
        }
        ?>

        <br><br>

        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2023 Twoja Firma. Wszelkie prawa zastrzeżone.</p>
    </footer>

    <script src="../JS/script.js"></script>
</body>
</html>