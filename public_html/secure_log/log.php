<?php
require_once '../config.php';
session_start();


// on va aller chercher le speudo dans le cookie
if(isset($_COOKIE['auto_log'])){
    
$tc = explode('#', $_COOKIE['auto_log']);
$pseudo=isset($tc[0]) ? ( get_magic_quotes_gpc() ? $tc[0] : $tc[0]) : '';
$password = isset($tc[1]) ? $tc[1] : '';

$chek = $db->prepare('SELECT pseudo, password, token from utilisateur WHERE pseudo = ?');
$chek->execute(array($pseudo));
$data = $chek->fetch();
$row = $chek->rowCount();

    if($row == 1){
        #Utilisateur vérifier
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['user'] = $data['token'];
        
        if(isset($_GET['redirect']) && !empty($_GET['redirect'])){
            if($_GET['redirect'] != '/index.php'){
                header('location: ' . $_GET['redirect']);
            }else{
                header('location: ../landing/Tout.php');
            }
        }else{
            header('location: ../index.php');
        }
    }else{
        #Utilisateur non vérifier
        header('Location: ../index.php');
    }

}else{
    print('Cookie non disponible retour index.php');
}

?>