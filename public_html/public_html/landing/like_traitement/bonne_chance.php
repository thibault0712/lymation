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
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

    if(isset($_GET['id']) && isset($_GET['page'])){
        $req = $db->prepare('SELECT * FROM like_verification WHERE id = ? AND token = ? AND name = ?');
        $req->execute(array(htmlspecialchars($_GET['id']), $_SESSION['user'], 'bonne_chance'));
        $data = $req->fetch();
        $row = $req->rowCount();
        if($row == 1){
            $req = $db->prepare('DELETE FROM like_verification WHERE id = ? AND token = ? AND name = ?');
            $req->execute(array(htmlspecialchars($_GET['id']), $_SESSION['user'], 'bonne_chance'));

            $number = $db->prepare('SELECT * FROM like_number WHERE id = ? AND name = ?');
            $number->execute(array(htmlspecialchars($_GET['id']), 'bonne_chance'));
            $number = $number->fetch();
            $req = $db->prepare('UPDATE like_number SET number = ? WHERE id = ? AND name = ?');
            $req->execute(array($number['number']-1, htmlspecialchars($_GET['id']), 'bonne_chance'));
            header('Location:../'.htmlspecialchars($_GET['page']).'.php#'.htmlspecialchars($_GET['id']));
            die();
        }else{
            $req = $db->prepare('INSERT INTO like_verification (id, token, name) VALUES (?, ?, ?)');
            $req->execute(array(htmlspecialchars($_GET['id']), $_SESSION['user'], 'bonne_chance'));
            
            $number = $db->prepare('SELECT * FROM like_number WHERE id = ? AND name = ?');
            $number->execute(array(htmlspecialchars($_GET['id']), 'bonne_chance'));
            $number = $number->fetch();
            $req = $db->prepare('UPDATE like_number SET number = ? WHERE id = ? AND name = ?');
            $req->execute(array($number['number']+1, htmlspecialchars($_GET['id']), 'bonne_chance'));
            header('Location:../'.htmlspecialchars($_GET['page']).'.php#'.htmlspecialchars($_GET['id']));
            die();
        }

    }else{
        header('Location:../tout.php');
        die();
    }