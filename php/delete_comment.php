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
$result8 = $connection->query(
    ("SELECT id_user from comments where id_comment={$_GET['id']} AND id_user={$_SESSION['id_user']}")
);
if ($row = $result8->fetch_assoc() != NULL) {
    $result3 = $connection->query(
        ("DELETE FROM comments WHERE id_comment={$_GET['id']}")
    );
}

header("Location: posts.php?id_post={$_GET['id_post']}");
