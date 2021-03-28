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
unset($_SESSION['post_del_profile']);
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
    <link rel="stylesheet" href="/css/comments_table.css">
    <link rel="stylesheet" href="/css/style_posts_content.css">
    <link rel="stylesheet" href="/css/arrow.css">

    <script defer src="/js/arrow.js"></script>
    <script defer src="/js/edit_comm.js"></script>

</head>

<body id="main">
    <div id="in_main">
        <?php
        include "header.php";
        include "header_stay.js";
        ?>



        <div id="content">
            <div id="posts">

                <?php
                $result = @$connection->query(
                    ("SELECT * FROM posts WHERE id_post={$_GET['id_post']}")
                );
                $row = $result->fetch_assoc();
                echo "<h1> {$row['name']}
                
            </h1> <br>
            <div id='content_posts'>{$row['content']}</div>";
                if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || $row != NULL && $row['id_user'] == $_SESSION['id_user']) {
                    echo "<td>  <a class='post_del' href='delete_post.php?id_post={$row['id_post']}'>Usuń post</a></td>";
                }
                $_SESSION['post_del_posts'] = true;
                echo "
            <br>
            <div id='comments'>
            
            <table>
            <div class='up_bar'>
            <p class='bar' id='temat'>Komentarz</p>
            <div id='right'>
            <p class='bar' id='autor'>Autor</p>
            <p class='bar' id='data'>Data</p>
            </div>
            </div> ";
                $comment = @$connection->query(
                    ("SELECT * FROM comments WHERE id_post={$_GET['id_post']} ORDER BY data_utworzenia desc")
                );

                while ($row4 = $comment->fetch_assoc()) {

                    echo "
                    <tr> <td class='post_comment'> <p>{$row4['comment']}</p> ";
                    if ($row4 != null && $row4['id_user'] == $_SESSION['id_user']) {
                        echo "
             
            <form action='/php/edit_comm.php' method='POST' id='form_edit_comm'>
            <input name='edit' value='{$row4['comment']}'><button type='submit' class='edit_comm_btn'>Zatwierdź</button>
            <input name='id_comment' type='hidden' value={$row4['id_comment']}>
            <input name='id_user' type='hidden' value={$row4['id_user']}>
            <input name='id_post' type='hidden' value={$_GET['id_post']}>
            </form> </td>
            
    ";
                    };

                    echo "<td id='btn'> ";
                    if ($row4 != null && $row4['id_user'] == $_SESSION['id_user']) {
                        echo "<button class='edit_button_comm'>Edytuj</button>";
                    };
                    echo " </td><td  class='comment_right'><a href='profile.php?id={$row4['id_user']}'>{$row4['autor']}</a> </td> <td  class='comment_right'><div> {$row4['data_utworzenia']} </div> </td><td class='x_td'>";
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || $row4 != NULL && $row4['id_user'] == $_SESSION['id_user']) {
                        echo "   <a href='delete_comment.php?id={$row4['id_comment']}&id_post={$row4['id_post']}'><img title='Usuń komentarz' class='x' src='/photos/x.svg'/> </a>";
                    }

                    echo "
                    </td> </tr>";
                }
                echo "            
            </table>
            <form action='/php/add_comm.php' method='POST' id='form_add_comm'>
            <textarea maxlength='250' rows='10' cols='50' name='input' placeholder='Dodaj komentarz'></textarea><button type='submit' class='add_comm_btn'>Zatwierdź</button>
            <input name='id_post' type='hidden' value={$_GET['id_post']}>
            </form>           
            <span class='ScrollTopButton' onclick='arrow()'></span>
            </div>";
                $comment->free_result();
                $result->free_result();
                $post_resU->free_result();
                ?>

            </div>

        </div>

    </div>

</body>

</html>