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

echo($row);

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
        #L'utilisateur c'est connecté avec un autre appareil
        setcookie('auto_log', NULL, -1); //Permet la suppression du cookie pour la version de dev
        setcookie('auto_log', NULL, -1, "/", "lymation.pq.lu", true, true); //Permet la suppression du cookie pour la vraie version
        header('Location: ../index.php?login_err=otherConection');
    }

}else{
    echo('Cookie non disponible retour index.php');
    header('location: ../index.php');
}

?>