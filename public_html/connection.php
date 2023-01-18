<?php
    session_start();
    require_once 'config.php';

    if(isset($_POST['pseudo']) && isset($_POST['password']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $password = htmlspecialchars($_POST['password']);

        $chek = $db->prepare('SELECT pseudo, password, token from utilisateur WHERE pseudo = ?');
        $chek->execute(array($pseudo));
        $data = $chek->fetch();
        $row = $chek->rowCount();

        if ($row == 1){
                $password = password_hash($password, PASSWORD_BCRYPT);
                
                if ($password === $data['password']){
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['user'] = $data['token'];
                    header('Location: /landing/Tout.php');
                    setcookie('auto_log', $pseudo . '#' . $password, ( time() + 86400 * 90 ));
                    die();
                    
                }else{
                    header('Location: /index.php?login_err=password');
                }
        }else{
            header('Location: /index.php?login_err=already');
        }
    }else{
        header('Location: /index.php');
    }
