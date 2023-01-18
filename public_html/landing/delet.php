<?php
session_start();
require_once '../config.php'; // ajout connexion bdd 
// si la session existe pas soit si l'on est pas connecté on redirige
if(!isset($_SESSION['user'])){
    header('Location:../index.php');
    die();
}

// On récupere les données de l'utilisateur
$req = $db->prepare('SELECT * FROM utilisateur WHERE id = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

//Parti génération
$article = $db->prepare('SELECT * FROM tout WHERE id = ? AND token = ?');
$article->execute(array($_GET['id'], $_SESSION['user']));
$row = $article->rowCount();

  if(isset($_GET['id']) && isset($_GET['page'])){
    if ($row == 1 || $_SESSION['user'] == '9ed090f6a3a62c7986f6d19c24b4fa9d1be15fa796eb0345678c8a49bf2bd09201a15e0ecc6da70b6c55b4d272e423c379b2b91d5e0d77887d58ce0f6928a49e') {
      $id = $_GET['id'];
      #$req = $db->prepare('DELETE FROM tout WHERE id = ?');
      #$req->execute(array($id));
      
      $req = $db->prepare('UPDATE tout SET anonyme = \'delet\' WHERE id = ?');
      $req->execute(array($id));
      
      header('Location:'.$_GET['page'].'.php?id='.$_GET['id']);
    }else{
        print('WARNING : Vous êtes pas autorisé à supprimer cet article, votre conte vient d\'être mis dans la cathégorie "potentiel danger"');
    }
  }
?>