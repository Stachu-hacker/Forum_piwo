<?php
session_start();
if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {

    header('Location: main.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍻Piwosze</title>
    <link rel="stylesheet" href="/css/style_log_in.css">
    <script defer src="/js/smiglo.js"></script>
    <script defer src="/js/blocking.js"></script>
    <script type="text/css" src="/js/cursor.js"></script>





</head>

<body id='index'>

    <div class="form" id='foorm'>
        <p id='piwosze'>Piwosze </p>
        <form class="log formularz" action="/php/log_in.php" method="post">
            <input name="login" type="text" placeholder="Login" />
            <input name="password" type="password" placeholder="Hasło" />
            <br>
            <button id="log_in" class="button" type="submit">Zaloguj się</button>
            <div id='frgt_options'>
                <span>Zapomniałeś hasła? </span>
                <span>Nie masz konta?</span>
            </div>
            <div id='buttons'>
                <br>
                <br>
                <button id="restart" class="button" onclick="	event.preventDefault(); password_restart_function()">Odzyskaj hasło</button>
                <button id="register" class="button" onclick="	event.preventDefault(); register_function()">Dołącz do piwoszy!</button>
            </div>


        </form>

    </div>

    <?php
    if (isset($_SESSION['error']))
        echo $_SESSION['error'];
    unset($_SESSION['error']);
    if (isset($_SESSION['new_password']))
        echo $_SESSION['new_password'];
    unset($_SESSION['new_password']);
    ?>


</body>

</html>