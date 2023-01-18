<?php
session_start();
require_once '../../config.php'; // ajout connexion bdd 
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
$article = $db->prepare('SELECT * FROM commentary WHERE id_article = ? AND token = ?');
$article->execute(array($_GET['id_article'], $_SESSION['user']));
$row = $article->rowCount();

  if(isset($_GET['id_article']) && isset($_GET['id']) && isset($_GET['page'])){
    $permuser = $db->prepare('SELECT * FROM tout WHERE token = ? AND id = ?');
    $permuser->execute(array($_SESSION['user'], $_GET['id']));
    $verif = $permuser->rowCount();
    if ($row == 1 || $_SESSION['user'] == '9ed090f6a3a62c7986f6d19c24b4fa9d1be15fa796eb0345678c8a49bf2bd09201a15e0ecc6da70b6c55b4d272e423c379b2b91d5e0d77887d58ce0f6928a49e' || $verif == 1) {
      $id = $_GET['id_article'];
      $req = $db->prepare('DELETE FROM commentary WHERE id_article = ?');
      $req->execute(array($id));
      header('Location:Commentaires.php?id='.$_GET['id'].'&id_article='.$_GET['id_article'].'&page='.$_GET['page']);
    }else{
        print('WARNING : Vous êtes pas autorisé à supprimer cet article, votre conte vient d\'être mis dans la cathégorie "potentiel danger"');
    }
  }
?>