<?php
if (isset($_GET['color'])) {
    $color = $_GET['color'];
    setcookie('bg', $color, time() + 3600, '/');
}
?>