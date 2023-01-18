<?php
    require_once 'config.php';

    if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['password_retype'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        $chek = $db->prepare('SELECT pseudo, password from utilisateur WHERE pseudo = ?');
        $chek->execute(array($pseudo));
        $data = $chek->fetch();
        $row = $chek->rowCount();
        
        

        if ($row == 0){
            if (!empty($pseudo) && strpos($pseudo, ' ', 1) === false){
                if (strlen ($pseudo) <= 16){
                    if (strlen ($password) >= 8 || !empty($password)){
                        if ($password == $password_retype){
                            $password = password_hash($password, PASSWORD_BCRYPT);
                            $ip = $_SERVER['REMOTE_ADDR'];
    
                            $insert = $db->prepare('INSERT INTO utilisateur(pseudo, password, ip, token) VALUES(:pseudo, :password, :ip, :token)');
                            $insert->execute(array(
                                'pseudo' => $pseudo,
                                'password' => $password,
                                'ip' => $ip,
                                'token' => bin2hex(openssl_random_pseudo_bytes(64))
                            ));
                            header('Location: /index.php?login_err=success');
                        }else{
                            header('Location: /inscription.php?reg_err=password');
                        }
                    }else{
                        header('Location: /inscription.php?reg_err=password_lenght');
                    }
                }else{
                    header('Location: /inscription.php?reg_err=pseudo_length');
                }
            }else{
                header('Location: /inscription.php?reg_err=space');  
            }
        }else{
            header('Location: /inscription.php?reg_err=already');
        }
    }