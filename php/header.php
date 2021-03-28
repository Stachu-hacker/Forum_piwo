<!-- <script src="/js/header_stay.js"></script> -->
<div class="header" id="header">
    <div id="opcje">
        <ul>
            <li id='one'><a class='top' href="/php/main.php">Strona główna</a> </li>
            <li id='two'><a class='top' href="/php/profile.php">Profil</a> </li>
            <li id='three'><a class='top' href="/php/log_out.php">Wyloguj</a></li>
            <hr />
        </ul>
        <p id='min'>

            <?php
            require "connect.php";
            $connection = @new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno != 0) {
                echo "Error:" . $connection->connect_errno;
                $_SESSION['error'] = '<p id="error">Brak połącznia z bazą danych!</p>';
                header('Location: index.php');
            } else {
                $login = $_SESSION['login'];
                $result = @$connection->query(
                    ("SELECT * FROM Users WHERE `login`= '{$login}'")
                );
                $row1 = $result->fetch_assoc();
                $_SESSION['photo'] = $row1['photo_url'];
                $photo = $_SESSION['photo'];

                echo " <a href='profile.php' ><img id='small_photo' src='{$_SESSION["photo"]}' /> </a>";
            }
            ?>

        </p>


    </div>
</div>