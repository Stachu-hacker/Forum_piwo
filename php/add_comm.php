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
if ($_POST['input'] != NULL) {
    $result = $connection->query(
        ("INSERT INTO comments (comment, data_utworzenia, autor, id_user, id_post) VALUES ('{$_POST['input']}','{$date}','{$_SESSION['login']}',{$_SESSION['id_user']},{$_POST['id_post']} ); ")
    );
}
$id = mysqli_insert_id($connection);
header("Location: posts.php?id_post={$_POST['id_post']}");
