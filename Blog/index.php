<?php
session_start();
if (isset($_SESSION['logged'])){
header("Location: Service/blog.php");
} else {
    header("Location: Login/login_page.php");
}