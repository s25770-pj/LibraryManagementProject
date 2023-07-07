<?php

session_start();

require_once "../Includes/config.php";
require_once $config;
if (!isset($_SESSION['login']))
	{
		header('Location:'. $local);
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kup Karnet Premium</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/script.js"></script>
    <link rel="stylesheet" href="../Style/page.css">
</head>
<body>
    <header>
    <?php require_once $header; ?>
    </header>
    <main>
        <section>
            <h1>Informacje o karnecie</h1>
            <?php
                $id = $_SESSION['id'];
                $date_time = new DateTime(date('Y-m-d H:i:s'));
                $today = $date_time->format('Y-m-d H:i:s');

                $query = "SELECT premiumExpirationDate FROM users WHERE id = $id ";
                $result = $connection->query($query);
                $row = $result->fetch_assoc();
            
                $_SESSION['premiumExpirationDate'] = $row['premiumExpirationDate'];
            ?>
            <p>Data wygaśnięcia konta premium: <br><?php echo $_SESSION['premiumExpirationDate']; ?></p>
            
            <?php
                $today = DateTime::createFromFormat('Y-m-d H:i:s', $today);
                $end = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['premiumExpirationDate']);
                $difference = $date_time->diff($end);
            ?>
            
            <div id="counter">
                <?php
                    if ($date_time < $end) {
                        echo "Pozostały czas pakietu premium: <br>" . $difference->format('%y years, %m months, %d dni, %h hours, %i minutes, %s seconds');
                    } else {
                        echo "<p>Pakiet premium nieaktywny.</p>";
                    }
                    ?>
            </div>
            <?php if ($today > $end) { ?>
            <br> <button class="button_back" onclick="window.location.href='<?php echo $premium_purchase?>'">Aktywuj pakiet</button>
            <?php
            } else {
                ?>
                <br> <button class="button_back" onclick="window.location.href='<?php echo $premium_purchase?>'">Przedłuż pakiet</button>
            <?php } ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Twoja Firma. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>