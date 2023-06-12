<?php
$connection = new mysqli($host, $db_user, $db_password, $db_name);
      
      if ($connection->connect_errno) {
          exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);
      }