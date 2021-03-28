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
    unset($_SESSION['new_user']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $login= $_POST['login'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];
    $email = $_POST['email'];
    $piwo = $_POST['piwo'];
    $photo = $_POST['photo'];

    
    $first_name=htmlentities($first_name, ENT_QUOTES, "UTF-8");
    $last_name=htmlentities($last_name, ENT_QUOTES, "UTF-8");
    $login=htmlentities($login, ENT_QUOTES, "UTF-8");
    $password=htmlentities($password, ENT_QUOTES, "UTF-8");
    $password_check=htmlentities($password_check, ENT_QUOTES, "UTF-8");
    $email=htmlentities($email, ENT_QUOTES, "UTF-8");    
    $piwo=htmlentities($piwo, ENT_QUOTES, "UTF-8");    
    $photo=htmlentities($photo, ENT_QUOTES, "UTF-8");    
    $password_hash=password_hash($password, PASSWORD_DEFAULT);
    
    $key='6Lfd1XQaAAAAAJoMPmd5IYYFRR2BPvqP_JXCepbg';
    $key_check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$_POST['g-recaptcha-response']);
    $answer=json_decode($key_check);
    
    if($first_name === null || $last_name === null || $login === null || $password === null || $email === null || $piwo === null || $password_check === null || $photo === null){ header('Location: /php/index.php'); }
    else{
        
        if($password === $password_check && $answer->success== true && ctype_alnum($login))  {  
    if ($result = @$connection -> query(
    sprintf("SELECT * FROM Users WHERE login= '%s' ",
    mysqli_real_escape_string($connection, $login)   
    )))
    {
        $user_cnt = $result -> num_rows;
        if ($user_cnt===0){ 
            $sql="INSERT INTO Users (first_name, last_name, login, password, email, ulubione_piwo, photo_url) VALUES ('{$first_name}', '{$last_name}', '{$login}', '{$password_hash}', '{$email}', '{$piwo}', '{$photo}'); " ;
            $test=@$connection -> query($sql);     
            
            $_SESSION['photo']=$row['photo_url'];
            $_SESSION['new_user']=true;
            header('Location: /php/index.php');
        }
        else{
            
            
            header('Location: /php/index.php');
            
        }
    } 
    }
    else{
    
     header('Location: /php/index.php');}

    }
}
