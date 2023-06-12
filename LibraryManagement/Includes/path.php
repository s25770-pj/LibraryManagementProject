<?php

    require_once "../SQL_Config/connect.php";

    $data_base = "../SQL_Config/connect.php";

    $images = "../Images/";

    $page = "../Page/page.php";
    $user_panel = "../Page/user_panel.php";

    $premium = "../Service/premium_purchase.php";
    $package_premium = "../Page/package_premium.php";

    $login = "../Login/login.php";
    $login_panel = "../Login/login_panel.php";
    $logout = "../Login/logout.php";

    $registration = "../Register/registration.php";

    $book_details = "../Page/book_details.php";
    $add_book = "../Service/add_book.php";
    $rent_book = "../Service/rent_book.php";
    $rentals = "../Storage/rentals.php";

    $rebalance = "../Service/recharge_balance.php";
    $add_balance = "../Service/add_balance.php";

    $header = "../Includes/header.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);
      
      if ($connection->connect_errno) {
          exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);
      }