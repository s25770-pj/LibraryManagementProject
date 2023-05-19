<?php

session_set_cookie_params(1800);

$_SESSION['last_activity'] = time();

$session_timeout = 10; // czas nieaktywności w sekundach (np. 30 minut)
$current_time = time();
$last_activity = $_SESSION['last_activity'];

if ($current_time - $last_activity > $session_timeout) {

    session_unset(); 
    session_destroy(); 

    header('Location: logout.php');
    exit();
} else {

    $_SESSION['last_activity'] = $current_time;

}

?>