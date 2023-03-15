<?php
    session_start();
    require_once 'config.php';

    if(isset($_POST['pseudo']) && isset($_POST['password']))
    {
        $pseudo = htmlentities($_POST['pseudo']);
        $password = htmlentities($_POST['password']);

        $chek = $db->prepare('SELECT pseudo, password, token from utilisateur WHERE pseudo = ?');
        $chek->execute(array($pseudo));
        $data = $chek->fetch();
        $row = $chek->rowCount();

        if ($row == 1){
                if (password_verify($password, $data['password'])){
                    $auto_log = bin2hex(openssl_random_pseudo_bytes(64));
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['user'] = $data['token'];
                    
                    $req = $db->prepare('UPDATE utilisateur SET auto_log = ? WHERE token = ?');
                    $req->execute(array($auto_log, $data['token']));
                    setcookie('auto_log', $auto_log, ( time() + 86400 * 30 ), "/", "lymation.pq.lu", true, true);
                    #setcookie('auto_log', $auto_log, ( time() + 86400 * 30 ));
                    header('Location: /landing/Tout.php');
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
?>