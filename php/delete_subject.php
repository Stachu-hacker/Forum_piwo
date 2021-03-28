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
$result_sub = $connection->query(
    ("SELECT id_tematu FROM tematy WHERE id_tematu={$_GET['id']}")
);
if ($row_sub = $result_sub->fetch_assoc() != NULL) {
    $result_post = $connection->query(
        ("SELECT id_post FROM posts WHERE id_tematu={$_GET['id']}")
    );
    $post_id = $result_post->fetch_assoc();
    $result = $connection->query(
        ("DELETE FROM comments WHERE id_post={$post_id['id_post']}")
    );

    $result2 = $connection->query(
        ("DELETE FROM posts WHERE id_tematu={$_GET['id']}")
    );

    $result3 = $connection->query(
        ("DELETE FROM tematy WHERE id_tematu={$_GET['id']}")
    );
}
if (isset($_SESSION['del_from_prof'])) {
    header('Location: profile.php');
} else if (isset($_SESSION['del_from_main'])) {
    header('Location: main.php');
}
