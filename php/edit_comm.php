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

if ($_POST['edit'] != NULL && $_POST['id_user'] == $_SESSION['id_user'] || isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    $result = $connection->query(
        ("UPDATE comments SET comment='{$_POST['edit']}' WHERE id_comment={$_POST['id_comment']};")
    );
}

header("Location: posts.php?id_post={$_POST['id_post']}");
