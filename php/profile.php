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
    }
    unset($_SESSION['del_from_main']);
    if (!isset($_GET['id']) || $_GET['id'] == $_SESSION['id_user']) {
        $id = $_SESSION['id_user'];
    } else {
        $id = $_GET['id'];
    }
    $_SESSION['id_prof'] = $id;
    $result = @$connection->query(
        ("SELECT * FROM Users WHERE `id_user`= '{$id}'")
    );
    $row = $result->fetch_assoc();

    $result->free_result();
}
unset($_SESSION['post_del_posts']);
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="/css/style_profile.css">
    <link rel="stylesheet" href="/css/style_header.css">
    <link rel="stylesheet" href="/css/style_table.css">
    <link rel="stylesheet" href="/css/arrow.css">

    <script defer src="/js/arrow.js"></script>
    <script defer src="/js/show_form_prof.js"></script>

</head>

<body>
    <div id='profil'>
        <?php
        include "header.php";
        include "header_stay.js"
        ?>
        <div id='content'>


            <div id='pht_tlo' style="background-image: url(<?php
                                                            if ($row['photo_url_back']) {
                                                                echo "{$row['photo_url_back']}";
                                                            } else {
                                                                echo "{$row['photo_url']}";
                                                            }
                                                            ?> );">
                <div id='pht'>
                    <?php
                    echo " <img src='{$row["photo_url"]}' />";

                    ?>
                    <div id='bttns'>
                        <?php if (!isset($_GET['id']) || $_GET['id'] == $_SESSION['id_user']) {
                            echo "
                        <div>
                        <button id='b_ucb' class='bttn_profile'>Zmień tło</button>
                        <form class='prof_form' id='change_b' action='change_pht.php' method='POST'> 
                        <input name='url_b' placeholder='URL zdjęcia'/>
                        <button>Zatwierdź</button>
                        </form>
                        </div>
                       
                        <div>
                        <button id='b_uc' class='bttn_profile'>Zmień zdjęcie</button>
                        <form class='prof_form' id='change' action='change_pht.php' method='POST'> 
                        <input name='url' placeholder='URL zdjęcia'/>
                        <button>Zatwierdź</button>
                        </form>
                        </div>
                           
                        ";
                        }
                        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || !isset($_GET['id']) || $_GET['id'] == $_SESSION['id_user']) {
                            echo "
                                <div>
                        <button  id='b_ubb' class='bttn_profile' >Zablokuj konto</button>                            
                        <form id='blck_form' class='prof_form' action='block_user.php 'method='POST'>
                        <input type='password' name='pswd' placeholder='Podaj hasło'/>
                        <button id='b_ub' data-activated=
                        {$row['activated']}>Zatwierdź</button>
                        </form>
                        </div>
                        ";
                        };
                        ?>
                    </div>
                </div>

            </div>

            <div id='info'>
                <?php
                echo "<div> <p>Login: </p> <p>{$row["login"]}</p> </div>";
                echo "<div> <p>Imie:  </p> <p>{$row['first_name']}</p> </div>";
                echo "<div> <p>Nazwisko:  </p> <p>{$row["last_name"]}</p> </div>";
                echo "<div> <p>Ulubione piwo:  </p> <p>{$row["ulubione_piwo"]}</p> </div>";
                echo "<div> <p>E-mail:  </p> <p>{$row["email"]}</p> </div>";

                ?>
            </div>


            <div id='ur_posts'>
                <h1>Tematy:</h1>
                <table class='subjects'>
                    <?php
                    $result = @$connection->query(
                        ("SELECT * FROM tematy where id_user={$id} ORDER BY data_utworzenia desc")
                    );

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
             <td class='subject'> {$row['nazwa']}  ";

                        $post_res = @$connection->query(
                            ("SELECT * FROM posts where id_tematu={$row['id_tematu']} ORDER BY id_post desc")
                        );
                        while ($row2 = $post_res->fetch_assoc()) {
                            echo "  <div class=post_name > <a href='posts.php?id_post={$row2['id_post']}'>{$row2['name']} </a> </div>";
                            $_SESSION['post_title'] = $row2['name'];
                        }
                        $post_res->free_result();
                        echo " 
            </td>
          <td class='table_right'> {$row['data_utworzenia']} </td> ";
                        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || !isset($_GET['id']) || $_GET['id'] == $_SESSION['id_user']) {
                            echo " <td class='x_td'>  <a href='delete_subject.php?id={$row['id_tematu']}'><img title='Usuń temat' class='x' src='/photos/x.svg'/> </a></td>";
                        }

                        echo "</tr>";
                        $_SESSION['del_from_prof'] = true;
                    }
                    echo "</table>
                   
                     <br>
            <h1>Posty:</h1>
            <table class='subjects'>
            ";
                    $post_resU = @$connection->query(
                        ("SELECT * FROM posts where id_user={$id}")
                    );
                    while ($row3 = $post_resU->fetch_assoc()) {
                        echo " <tr><td>
                 <div class=post_name2 > <a href='posts.php?id_post={$row3['id_post']}'>{$row3['name']} </a> </div> ";

                        echo "
                 </td>
                  <div id='table_right'><td class='table_right'> {$row3['data_utworzenia']} ";
                        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || !isset($_GET['id']) || $_GET['id'] == $_SESSION['id_user']) {
                            echo "</td> <td class='x_td'>  <a href='delete_post.php?id={$row3['id_post']}'><img title='Usuń post' class='x' src='/photos/x.svg'/> </a></td>";
                        }
                        $_SESSION['post_del_profile'] = true;
                        echo "</div>  </tr>";
                    }
                    echo "</table>";

                    $result->free_result();
                    $post_resU->free_result();
                    $post_res->free_result();

                    ?>

            </div>

        </div>


    </div>



    </div>
    <span class="ScrollTopButton" onclick="arrow()"></span>

</body>