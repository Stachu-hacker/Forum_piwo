<?php
session_start();
if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
    header('Location: index.php');
    exit();
}
require_once "connect.php";

$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if ($connection->connect_errno != 0) {
    echo "Error:" . $connection->connect_errno;
    $_SESSION['error'] = '<p id="error">Brak połącznia z bazą danych!</p>';
    header('Location: index.php');
} else {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    if ($result = @$connection->query(
        sprintf(
            "SELECT * FROM Users WHERE login= '%s' ",
            mysqli_real_escape_string($connection, $login),
        )
    )) {


        $user_cnt = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($user_cnt > 0) {


            if (password_verify($password, $row['password'])) {
                if ($row['activated'] == 0) {
                    $_SESSION['error'] = '<p class="alert" id="error">Twoje konto jest zablokowane!</p>';
                    header('Location: index.php');
                    exit();
                }
                $_SESSION['logged'] = true;
                if ($row['admin'] == 1) {
                    $_SESSION['admin'] = true;
                }

                $_SESSION['login'] = $row['login'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['id_user'] = $row['id_user'];
                unset($_SESSION['error']);
                $result->free_result();
                header('Location: /php/main.php');
            } else {
                $_SESSION['error'] = '<p class="alert" id="error">Zły login lub hasło!</p>';
                header('Location: index.php');
            }
        } else {

            $_SESSION['error'] = '<p class="alert" id="error">Zły login lub hasło!</p>';
            header('Location: index.php');
        }
    }

    $connection->close();
}
