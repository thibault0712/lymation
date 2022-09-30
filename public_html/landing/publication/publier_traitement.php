<?php
    session_start();
    require_once '../../config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:../../index.php');
        die();
    }

    // On récupere les données de l'utilisateur
    $req = $db->prepare('SELECT * FROM utilisateur WHERE id = ?');
    $req->execute(array($_SESSION['pseudo']));
    $data = $req->fetch();

    $date = $db->prepare('SELECT MAX(date) FROM tout WHERE token = ?');
    $date->execute(array($_SESSION['user']));
    $date_max = $date->fetch();

    $stamp = date('Y-m-d H:i:s', strtotime($date_max[0] . ' + 30 minutes')); 

    if(isset($_POST['cathegorie']) && isset($_POST['message'])){
        $cathegorie = htmlspecialchars($_POST['cathegorie']);
        $message = htmlspecialchars($_POST['message']);
        $message = trim($message);
        
        if (strlen ($message) <= 500){
            if(!empty($_POST['message']) && !empty($message)){
                if($stamp <= date("Y-m-d H:i:s") || empty($date_max[0])){
                    if(isset($_POST['checkbox'])){
                        $anonyme = 'anonyme';
                        $response = sendMessage('Un anonyme ', $cathegorie);
                        $return["allresponses"] = $response;
                        $return = json_encode($return);
    
                        $data = json_decode($response, true);
                        print_r($data);
                        $id = $data['id'];
                        print_r($id);
    
                        print("\n\nJSON received:\n");
                        print($return);
                    }else{
                        $response = sendMessage($_SESSION['pseudo'], $cathegorie);
                        $return["allresponses"] = $response;
                        $return = json_encode($return);
    
                        $data = json_decode($response, true);
                        print_r($data);
                        $id = $data['id'];
                        print_r($id);
    
                        print("\n\nJSON received:\n");
                        print($return);
                        $anonyme = 'null';
                    }
                    $req = $db->prepare('INSERT INTO tout (cathegorie, token, contenu, anonyme) VALUES (?, ?, ?, ?)');
                    $req->execute(array($cathegorie, $_SESSION['user'], $message, $anonyme));
    
                    $id = $db->prepare('SELECT MAX(id) FROM tout');
                    $id->execute();
                    $id = $id->fetch();
                    $req = $db->prepare('INSERT INTO like_number (id, name) VALUES (?, ?)');
                    $req->execute(array($id[0], 'bonne_chance'));
                    $req->execute(array($id[0], 'pourquoi'));
                    $req->execute(array($id[0], 'chaud'));
                    $req->execute(array($id[0], 'tu_veux_la_prison'));
    
                    header('Location: ../Tout.php');
                }else{
                    header('Location: ../publication/Publier.php?reg_err=date');
                }
            }else{
                header('Location: ../publication/Publier.php?reg_err=notwriten');
            }
        }else{
            header('Location: ../publication/Publier.php?reg_err=message');
        }
    }else{
        header('Location: ../publication/Publier.php?reg_err=unknown');
    }






    function sendMessage($pseudo, $cathegorie) {
        $content      = array(
            "en" => $pseudo.' a publié un nouveau message dans la cathegorie '.$cathegorie
        );
        $hashes_array = array();
        $fields = array(
            'app_id' => "3ad21bac-4e1f-4b63-ae5e-63e6cea63ca8",
            'included_segments' => array(
                'Subscribed Users'
            ),
            'data' => array(
                "foo" => "bar"
            ),
            'contents' => $content,
            'web_buttons' => $hashes_array
        );
        
        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic OWJjYTdkNjYtMTIzZi00MjRlLWE5ZWYtOTI2ZDIzZTYwNjFh'
        ));
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