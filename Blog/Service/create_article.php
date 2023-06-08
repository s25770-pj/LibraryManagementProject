<?php
session_start();

require_once '../Config/config.php';

if (!isset($_SESSION['logged'])) {
    header("Location: $login_page");
    die;
}
?>
