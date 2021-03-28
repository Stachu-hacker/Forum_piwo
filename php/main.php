<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}
require "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if ($connection->connect_errno != 0) {
    echo "Error:" . $connection->connect_errno;
    $_SESSION['error'] = '<p id="error">Brak połącznia z bazą danych!</p>';
    header('Location: index.php');
}
unset($_SESSION['del_from_prof']);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piwosze</title>
    <link rel="stylesheet" href="/css/style_main.css">
    <link rel="stylesheet" href="/css/style_header.css">
    <link rel="stylesheet" href="/css/style_table.css">
    <link rel="stylesheet" href="/css/arrow.css">

    <script defer src="/js/arrow.js"></script>
    <script defer src="/js/add.js"></script>
</head>

<body id="main">
    <div id="in_main">
        <?php
        include "header.php";
        include "header_stay.js"
        ?>

        <div id="content">
            <div id="posts">

                <div class='up_bar'>
                    <p class='bar' id="temat">Temat</p>
                    <div id='prawa'>
                        <p class='bar' id="data">Data</p>
                        <p class='bar' id="autor">Autor</p>
                    </div>
                </div>
                <div class='add'><a class='addtext'>Dodaj swój temat</a></div>
                <form action='add_subject.php' method="POST">
                    <div class='add_form'>
                        <input name='sub' placeholder="Nazwa tematu">
                        <button type='submit' class='add_button'>Dodaj</button>
                    </div>
                </form>

                <table class='subjects'>
                    <?php
                    $result = @$connection->query(
                        ("SELECT * FROM tematy ORDER BY data_utworzenia desc")
                    );

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
             <td class='subject'> {$row['nazwa']}  ";

                        echo "
                        <form action='/php/add_post.php' method='POST' id='form_add_post'>
                        <input name='name' placeholder='Nazwa posta'><input name='desc' placeholder='Opis posta'> <button type='submit' class='add_post_btn'>Dodaj</button>
                        <input name='id_tem' type='hidden' value='{$row['id_tematu']}'>
                        </form> ";
                        $post_res = @$connection->query(
                            ("SELECT * FROM posts where id_tematu={$row['id_tematu']} ORDER BY id_post desc")
                        );
                        while ($row2 = $post_res->fetch_assoc()) {
                            echo "  <div class=post_name > <a href='posts.php?id_post={$row2['id_post']}'>{$row2['name']} </a> </div>";
                            $_SESSION['post_title'] = $row2['name'];
                        }
                        $post_res->free_result();
                        $result_user = @$connection->query(
                            ("SELECT id_user FROM Users where login='{$row['autor']}' ")
                        );
                        $row_user = $result_user->fetch_assoc();
                        echo " 
            </td><td id='btn'>            
                <button class='add_button_post'>Dodaj</button>
        </td>
            <div id='table_right'><td class='table_right'> {$row['data_utworzenia']} </td> <td class='table_right'><a href='profile.php?id={$row_user['id_user']}'>{$row['autor']}</a> ";
                        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || $row != null && $row['id_user'] == $_SESSION['id_user']) {
                            echo " <div class='x_td'>  <a href='delete_subject.php?id={$row['id_tematu']}'><img title='Usuń temat' class='x' src='/photos/x.svg'/> </a></div>";
                            $_SESSION['del_from_main'] = true;
                        }
                        echo "</td></div></tr>";
                    }
                    $result->free_result();
                    $result_user->free_result();

                    ?>
                </table>

            </div>
        </div>
        <span class="ScrollTopButton" onclick="arrow()"></span>
    </div>
</body>

</html>