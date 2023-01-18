<?php
require_once '../config.php';
session_start();


// on va aller chercher le speudo dans le cookie
if(isset($_COOKIE['auto_log'])){
    
$auto_log = $_COOKIE['auto_log'];

$chek = $db->prepare('SELECT pseudo, password, token from utilisateur WHERE auto_log = ?');
$chek->execute(array($auto_log));
$data = $chek->fetch();
$row = $chek->rowCount();

    if($row == 1){
        #Utilisateur vérifier
        $_SESSION['pseudo'] = $data['pseudo'];
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
        unset($_COOKIE['auto_log']);
        header('Location: ../index.php');
    }

}else{
    print('Cookie non disponible retour index.php');
    header('location: ../index.php');
}

?>