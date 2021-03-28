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
$pswd = $connection->query(
    sprintf("SELECT * FROM Users Where id_user='%s'", mysqli_real_escape_string($connection, $_SESSION['id_user']))
);
$psw = $pswd->fetch_assoc();
// die($_SESSION['id_user']);
if (password_verify($_POST['pswd'], $psw['password'])) {

    $us = $connection->query(
        ("SELECT activated FROM Users WHERE id_user={$_SESSION['id_prof']};")
    );
    $check = $us->fetch_array();
    if ($check['activated']) {
        $result = $connection->query(
            ("UPDATE Users SET activated=0 WHERE id_user={$_SESSION['id_prof']};")
        );
    } else {
        $result2 = $connection->query(
            ("UPDATE Users SET activated=1 WHERE id_user={$_SESSION['id_prof']};")
        );
    };

    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        header('Location:profile.php');
    } else {
        unset($_SESSION['logged']);
        header('Location:index.php');
    };
} else {
    header('Location:profile.php');
}
