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
	<link rel="stylesheet" href="../Style/style.css">

</head>

<body>

<?php
require_once $header;

?>

<div class = 'pod_bannerem'>

    <div class = 'lewa'></div>

    <div class = 'srodek'>

        <div class = 'searching'></div>

        <div id='bookResults'></div>

        <?php

        if ((isset($_SESSION['login']))) {

        $connection->close();

        }

        ?> 
                
        <br /><br />

        <?php

        if(isset($_SESSION['error']))	echo $_SESSION['error'];
        
        ?>

    </div>

    <div class = "prawa"></div> 

</div>

</body>

</html>