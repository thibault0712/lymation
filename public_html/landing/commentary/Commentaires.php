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

    $commentary = $db->prepare('SELECT * FROM commentary WHERE id_article ORDER BY id_article DESC');
    $commentary->execute();



    //vérification
    if(isset($_GET['id']) AND isset($_GET['page'])){
        $permuser = $db->prepare('SELECT * FROM tout WHERE token = ? AND id = ?');
        $permuser->execute(array($_SESSION['user'], $_GET['id']));
        $verif = $permuser->rowCount();
    }else{
      header('Location:../Tout.php');
      die(); 
    }

?>


<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
  <link rel="icon" type="image/png" href="icone.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Lymation - Commentaires</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Commentaires.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.12.5, nicepage.com">
    
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,200,300,400,500,600,700,800,900">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Commentaires">
    <meta property="og:type" content="website">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NTGKXWK9BZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NTGKXWK9BZ');
</script>
  </head>
  <body class="u-body u-xl-mode"><header class="u-clearfix u-header u-palette-1-dark-1 u-sticky u-sticky-a293 u-valign-middle-sm u-header" id="sec-4ebf"><a <?php echo "href=../".$_GET['page'].".php#".$_GET['id']; ?> class="u-border-none u-btn u-button-style u-hover-palette-1-light-1 u-palette-1-dark-1 u-btn-1"><span class="u-file-icon u-icon u-text-white u-icon-1"></span>&nbsp;
      </a><p class="u-align-center u-custom-font u-font-roboto-slab u-hidden-lg u-hidden-md u-hidden-sm u-hidden-xl u-text u-text-1">
        <span style="font-weight: 700; font-size: 1.25rem;">COMMENTAIRES</span>
        <br>
      </p><p class="u-align-center u-custom-font u-font-roboto-slab u-hidden-lg u-hidden-md u-hidden-sm u-hidden-xl u-text u-text-2">
        <span style="font-weight: 700; font-size: 1.25rem;">COMMENTAIRES</span>
        <br>
      </p><p class="u-align-center u-custom-font u-font-roboto-slab u-hidden-xs u-text u-text-3">
        <span style="font-weight: 700; font-size: 1.875rem;">COMMENTAIRES</span>
        <br>
      </p></header>
    <section class="u-clearfix u-section-1" id="sec-f010">
    <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {

                        case 'message':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> Votre message est trop long (taille maximale 250 caractères).
                            </div>
                        <?php
                        break;

                        case 'empty':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> Veuillez remplir tous les champs.
                            </div>
                        <?php 
                        break;

                        case 'time':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> vous devez attendre 1 minute avant de publier un nouveau message.
                            </div>
                        <?php 

                    }
                }
      ?>
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-expanded-width-lg u-expanded-width-md u-expanded-width-sm u-expanded-width-xl u-form u-form-1">
          <form <?php echo "action=Commentaires_traitement.php?id=".$_GET['id']."&page=".$_GET['page']; ?> method="POST" class="u-clearfix u-form-custom-backend u-form-horizontal u-form-spacing-15 u-inner-form" style="padding: 15px;" source="custom" redirect="true" name="form">
            <div class="u-form-group u-form-name u-label-none">
              <label for="name-ef64" class="u-label">Name</label>
              <input type="text" placeholder="Ajouter un commentaire" id="name-ef64" name="commentary" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-input-1" required="">
            </div>
            <div class="u-form-group u-form-submit">
              <a href="#" class="u-btn u-btn-submit u-button-style u-btn-1">publier</a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>
          </form>
        </div>
        <br/>
        <?php while($c = $commentary->fetch()) { 
        if($c['id'] == $_GET['id']) {
        ?>
        <div class="u-container-style u-expanded-width u-group u-shape-rectangle u-white u-group-1">
          <div class="u-container-layout u-container-layout-1">
          <?php if($c['token'] == $_SESSION['user'] || $_SESSION['user'] == '9ed090f6a3a62c7986f6d19c24b4fa9d1be15fa796eb0345678c8a49bf2bd09201a15e0ecc6da70b6c55b4d272e423c379b2b91d5e0d77887d58ce0f6928a49e' || $verif == 1) { ?>
          <a <?php echo "href=delet.php?id_article=".$c['id_article']."&page=".$_GET['page']."&id=".$_GET['id']; ?> class="u-btn u-button-style u-white u-btn-2"><span class="u-file-icon u-icon u-text-custom-color-1 u-icon-1"><img src="images/2.png" alt=""></span></a>
          <?php }else echo '</br>'; ?>
            <h6 class="u-text u-text-default u-text-1">
              <?php
                $pseudo = $db->prepare('SELECT * FROM utilisateur WHERE token = ?');
                $pseudo->execute(array($c['token'])); 
                $data = $pseudo->fetch();
                echo $data['pseudo'];
              ?></h6>
            <p class="u-text u-text-2"><?php echo $c['contenu']; ?></p>
            <p class="u-text u-text-default u-text-grey-40 u-text-3"><?php echo $c['date']; ?></p>
          </div>
        </div>
        <?php }} ?>
      </div>
    </section>
</html>