<?php
session_start();
require "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if ($connection->connect_errno != 0) {
    echo "Error:" . $connection->connect_errno;
    $_SESSION['error'] = '<p id="error">Brak połącznia z bazą danych!</p>';
    header('Location: index.php');
} else {
    if (!isset($_SESSION['logged'])) {
        header('Location: index.php');
        exit();
    };
}
$date = date("Y-m-d");
if ($_POST['sub'] != null) {
    $result4 = $connection->query(
        ("INSERT INTO tematy (nazwa, data_utworzenia, autor, id_user) VALUES ('{$_POST['sub']}', '{$date}','{$_SESSION['login']}',{$_SESSION['id_user']}); ")
    );
}
header('Location: main.php');
