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
$result9 = $connection->query(
    ("SELECT id_user from posts where id_post={$_GET['id_post']} AND id_user={$_SESSION['id_user']}")
);
if ($result9->num_rows > 0) {
    $comm_res = $connection->query(
        ("DELETE FROM comments WHERE id_post={$_GET['id_post']}")
    );
    $result = $connection->query(
        ("DELETE FROM posts WHERE id_post={$_GET['id_post']}")
    );
}
if (isset($_SESSION['post_del_profile'])) {
    header('Location: profile.php');
} else if (isset($_SESSION['post_del_posts'])) {
    header('Location: main.php');
}
