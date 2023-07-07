<?php

$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ksiegarnia";

$connection = new mysqli($host, $db_user, $db_password, $db_name);
      
      if ($connection->connect_errno) {
          exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);
      }
    $config = "../Includes/config.php";
    $images = "../Images/";

    $page = "../Page/index.php";
    $user_panel = "../Page/user_panel.php";
    $book_details = "../Page/book_details.php";
    $buy_premium = "../Page/buy_premium.php";

    $premium = "../Service/premium_purchase.php";
    $package_premium = "../Page/package_premium.php";
    $premium_purchase = "../Service/premium_purchase.php";

    $login = "../Login/login.php";
    $login_panel = "../Login/login_panel.php";
    $logout = "../Login/logout.php";

    $registration = "../Register/registration.php";
    $registrationCss = "../Style/registration.css";

    $add_book = "../Service/add_book.php";
    $rent_book = "../Service/rent_book.php";
    $rentals = "../Storage/rentals.php";

    $rebalance = "../Page/recharge_balance.php";
    $add_balance = "../Service/add_balance.php";

    $header = "../Includes/header.php";

    $style_css = "../Style/style.css";
    $page_css = "../Style/page.css";
