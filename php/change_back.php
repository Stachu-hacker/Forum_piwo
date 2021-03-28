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
if ($_POST['url'] != NULL) {
    $result = $connection->query(
        ("UPDATE Users SET photo_url_back='{$_POST['url']}' WHERE id_user={$_SESSION['id_user']};")
    );
    header('Location: profile.php');
} else {
    header('Location:profile.php');
}
