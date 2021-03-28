<?php
session_start();

$conn = require_once "connect.php";
$connection = @new mysqli($host,$db_user,$db_password,$db_name);
if($connection->connect_errno!=0)
{
    echo "Error:".$connection->connect_errno;
    $_SESSION['error']='<p id="error">Brak połącznia z bazą danych!</p>';
        header('Location: index.php');
}
else{
unset($_SESSION['new_password']);
$login=$_POST['login'];
$piwo=$_POST['piwo'];
$email=$_POST['email'];
$login=htmlentities($login, ENT_QUOTES, "UTF-8");
$piwo=htmlentities($piwo, ENT_QUOTES, "UTF-8");
$email=htmlentities($email, ENT_QUOTES, "UTF-8");

    
if ($result = @$connection -> query(
    sprintf("SELECT * FROM Users WHERE login= '%s' AND email='%s' AND ulubione_piwo='%s'",
    mysqli_real_escape_string($connection, $login),
    mysqli_real_escape_string($connection, $email),
    mysqli_real_escape_string($connection,$piwo))))
    {
        $user_cnt = $result -> num_rows;
        if ($user_cnt>0)
        {   
            function password_reset($length) {
                $uppercase = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'W', 'Y', 'Z');
                $lowercase = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'w', 'y', 'z');
                $number = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
            
                $password = NULL;
            
                for ($i = 0; $i < $length; $i++) {
                    $password .= $uppercase[rand(0, count($uppercase) - 1)];
                    $password .= $lowercase[rand(0, count($lowercase) - 1)];
                    $password .= $number[rand(0, count($number) - 1)];
                }
            
                return substr($password, 0, $length);
            }
            
            $myPassword = password_reset(12);
            $hash=password_hash($myPassword, PASSWORD_DEFAULT);

            $sql="UPDATE forum.Users SET password='$hash' WHERE login='$login'; " ;
            mysqli_query($connection, $sql);
            $_SESSION['new_password']="<p class='alert' id='new'>Twoje nowe hasło: {$myPassword}</p>";
            $result->free_result();
            header('Location: /php/index.php');
        }
        else{
            
            $_SESSION['error']='<p class="alert" id="error">Podane dane nie są zgodne!</p>';
            header('Location: index.php');
            
        
        }

    }

    $connection->close();
}
?>