<?php
    session_start();
    require_once '../../config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:../../index.php');
        die();
    }

    // On récupere les données de l'utilisateur
    $req = $db->prepare('SELECT * FROM utilisateur WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
    
    if(isset($_GET['id']) AND isset($_GET['page'])){
    $date = $db->prepare('SELECT MAX(date_verif) FROM commentary WHERE id = ? AND token = ?');
    $date->execute(array($_GET['id'] ,$_SESSION['user']));
    $date_max = $date->fetch();
    $stamp = date('Y-m-d H:i:s', strtotime($date_max[0] . ' + 1 minutes'));
    }else{
        header('Location: ../Tout.php');
    }

    if(isset($_POST['commentary'])){
        if(!empty($_POST['commentary']) && !empty(trim($_POST['commentary']))){
            if($stamp <= date("Y-m-d H:i:s") || empty($date_max[0])){
                if (strlen($_POST['commentary']) <= 250){
                    $req = $db->prepare('INSERT INTO commentary(token, id, contenu, date) VALUES(?, ?, ?, NOW())');
                    $req->execute(array($_SESSION['user'], $_GET['id'], $_POST['commentary']));
                    
                    $req = $db->prepare('SELECT * FROM tout WHERE id = ?');
                    $req->execute(array($_GET['id']));
                    $data = $req->fetch();
    
                    $req = $db->prepare('SELECT * FROM utilisateur WHERE token = ?');
                    $req->execute(array($data['token']));
                    $data = $req->fetch();
    
                    $response = sendMessage($data['id']);
                    $return["allresponses"] = $response;
                    $return = json_encode( $return);
                    
                    print("\n\nJSON received:\n");
                    print($return);
                    print("\n");
    
                    header('Location:Commentaires.php?id='.$_GET['id'].'&page='.$_GET['page']);
                    die();
                }else{
                    header('Location: Commentaires.php?reg_err=message&id='.$_GET['id'].'&page='.$_GET['page']);
                    die();
                }
            }else{
                header('Location: Commentaires.php?reg_err=time&id='.$_GET['id'].'&page='.$_GET['page']);
                die();
            }
        }else{
            header('Location: Commentaires.php?reg_err=empty&id='.$_GET['id'].'&page='.$_GET['page']);
            die();
        }
    }else{
        header('Location: Commentaires.php?reg_err=empty&id='.$_GET['id'].'&page='.$_GET['page']);
        die();
    }


    function sendMessage($token){
        
        $content = array(
            "en" => $_SESSION['pseudo'].' vient de répondre à votre publication !'
            );
        
        $fields = array(
            'app_id' => "3ad21bac-4e1f-4b63-ae5e-63e6cea63ca8",
            'include_external_user_ids' => array($token),
      'channel_for_external_user_ids' => 'push',
            'data' => array("foo" => "bar"),
            'contents' => $content
        );
        
        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic OWJjYTdkNjYtMTIzZi00MjRlLWE5ZWYtOTI2ZDIzZTYwNjFh'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
?>