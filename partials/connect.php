
<?php

$link = mysqli_connect('server_name', 'login', 'password');
if (!$link) {
    die('Nie połączono : ' . mysqli_error());
}

// Ustaw foo jako aktualną bazę danych
$db_selected = mysqli_select_db($link,'db_name');
if (!$db_selected) {
    die ('Nie można ustawić foo : ' . mysqli_error($link));
}
?>
