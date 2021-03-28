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

if ($_POST['desc'] != NULL && $_POST['name'] != NULL) {
    $result = $connection->query(
        ("INSERT INTO posts (id_user, content, id_tematu, name) VALUES ({$_SESSION['id_user']}, '{$_POST['desc']}',{$_POST['id_tem']},'{$_POST['name']}'); ")
    );
    $id = mysqli_insert_id($connection);
    header("Location: posts.php?id_post={$id}");
} else {
    header("Location: main.php");
}
