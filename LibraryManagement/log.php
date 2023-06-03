<?php

session_start();
$_SESSION['login'] = true;
$_SESSION['id'] = '1';
$_SESSION['user'] = '';
$_SESSION['email'] = '';
$_SESSION['premiumExpirationDate'] = '2023-09-13 17:20:48';
$_SESSION['access'] = 'user';
$_SESSION['wallet_id'] = '2';
var_dump($_SESSION);

echo "log";
