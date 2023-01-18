<?php 
    session_start();
    require_once '../config.php'; // ajout connexion bdd 
    
        //Verif si user set ou si cookie set pour la connexion sinon redirection
    if(!isset($_SESSION['user']) && isset($_COOKIE['auto_log'])){
        // on stoke la page en cours
        $page = $_SERVER['PHP_SELF'];
        // on fait la redirection vers le fichier de log
        header('location: ../secure_log/log.php?redirect=' . $page);
        exit;
    }
                
    if(!isset($_SESSION['user'])){
        header('Location:../index.php');
        die();
    }
        

    // On récupere les données de l'utilisateur
    $req = $db->prepare('SELECT * FROM utilisateur WHERE id = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

    //Parti génération

      $article = $db->prepare('SELECT * FROM tout WHERE id ORDER BY id DESC');
      $article->execute();
?>

<!DOCTYPE html>
<html style="font-size: 16px;" width=100%;>
  <head>
  <link rel="icon" type="image/png" href="icone.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Lymation">
    <meta name="description" content="">
    <title>Lymation - Pertes</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Pertes.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.11.3, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i">
    
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Pertes">
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
  <body class="u-body u-xl-mode"><header class="u-align-center u-clearfix u-header u-palette-1-base u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-header" id="sec-dad3" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction=""><h2 class="u-custom-font u-enable-responsive u-font-roboto u-text u-text-1">Lymation</h2><span class="u-enable-responsive u-file-icon u-icon u-text-white u-icon-1"><img src="images/1.png" alt=""></span><nav class="u-menu u-menu-one-level u-menu-open-right u-offcanvas u-menu-1" data-responsive-from="XS">
        <div class="menu-collapse" style="font-size: 1.25rem;">
          <a class="u-button-style u-custom-text-color u-nav-link" href="#">
            <svg class="u-svg-link" viewBox="0 0 24 24"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-8237"></use></svg>
            <svg class="u-svg-content" version="1.1" id="svg-8237" viewBox="0 0 16 16" x="0px" y="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><g><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
</g></svg>
          </a>
        </div>
        <div class="u-custom-menu u-nav-container">
          <ul class="u-nav u-unstyled u-nav-1"><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-white" href="publication/Publier.php">Publier</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-white" href="../logout.php">Déconnexion</a>
</li></ul>
        </div>
        <div class="u-custom-menu u-nav-container-collapse">
          <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
            <div class="u-inner-container-layout u-sidenav-overflow">
              <div class="u-menu-close"></div>
              <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="publication/Publier.php">Publier</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="../logout.php">Déconnexion</a>
</li></ul>
            </div>
          </div>
          <div class="u-black u-menu-overlay u-opacity u-opacity-20"></div>
        </div>
      </nav></header>
    <section class="u-clearfix u-valign-top-xs u-white u-section-1" id="sec-e5fe">
      <div class="u-expanded-width u-list u-list-1">
        <div class="u-repeater u-repeater-1">
          <div class="u-align-center u-container-style u-custom-item u-list-item u-palette-1-dark-2 u-repeater-item">
            <div class="u-container-layout u-similar-container u-container-layout-1">
              <a href="Tout.php" data-page-id="19442632" class="u-active-palette-1-dark-1 u-border-none u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-dark-2 u-btn-1">Tout</a>
            </div>
          </div>
          <div class="u-align-center u-container-style u-custom-item u-list-item u-palette-1-dark-2 u-repeater-item">
            <div class="u-container-layout u-similar-container u-container-layout-2">
              <a href="Crush.php" data-page-id="184087727" class="u-border-none u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-dark-2 u-btn-2">Crush</a>
            </div>
          </div>
          <div class="u-align-center u-container-style u-custom-item u-list-item u-palette-1-dark-2 u-repeater-item">
            <div class="u-container-layout u-similar-container u-container-layout-3">
              <a href="Pertes.php" data-page-id="2767023816" class="u-border-none u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-dark-1 u-btn-3">Pertes</a>
            </div>
          </div>
          <div class="u-align-center u-container-style u-custom-item u-list-item u-palette-1-dark-2 u-repeater-item">
            <div class="u-container-layout u-similar-container u-container-layout-4">
              <a href="Betises.php" data-page-id="56589408" class="u-border-none u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-dark-2 u-btn-4">Drôle</a>
            </div>
          </div>
          <div class="u-align-center u-container-style u-custom-item u-list-item u-palette-1-dark-2 u-repeater-item">
            <div class="u-container-layout u-similar-container u-container-layout-5">
              <a href="Autres.php" data-page-id="776423228" class="u-border-none u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-dark-2 u-btn-5">Autres</a>
            </div>
          </div>
        </div>
      </div>
      <?php while($c = $article->fetch()) { 
        if($c['cathegorie'] == 'pertes' && $c['anonyme'] != 'delet'){ ?>
              <div class="u-container-style u-grey-15 u-group u-radius-30 u-shape-round u-group-1" style="background-color : #F0F0F0;" id=<?php echo $c['id']; ?>>
        <div class="u-container-layout u-container-layout-6">
          <h6 class="u-text u-text-palette-1-dark-2 u-text-1">
          <?php if($c['token'] == $_SESSION['user']) { ?>
          <a <?php echo "href=delet.php?id=".$c['id']."&page=Pertes"; ?> style="background-image: none; margin: 25px auto 0 0; padding: 0;" ><span style="font-size: 1em;" class="u-file-icon u-icon u-text-custom-color-1 u-icon-1"><img src="images/2.png" alt=""></span></a>
          <?php } ?>
            <?php
              if($c['anonyme'] == 'anonyme'){
                echo 'Anonyme';
              }else{
                $pseudo = $db->prepare('SELECT * FROM utilisateur WHERE token = ?');
                $pseudo->execute(array($c['token'])); 
                $data = $pseudo->fetch();
                echo $data['pseudo'];
              }
            ?></h6>
          <div class="u-border-3 u-border-palette-1-dark-1 u-line u-line-horizontal u-line-1"></div>
          <p class="u-text u-text-2"><?= $c['contenu']?><br>
          </p>
          <div class="u-clearfix u-group-elements u-group-elements-1">
            <a <?php echo "href=like_traitement/pourquoi.php?page=Pertes&id=".$c['id'];?> class="u-border-none u-btn u-button-style u-custom-color-2 u-btn-6">Pourquoi ?<br>
            </a>
            <div class="u-container-style u-group u-shape-rectangle u-white u-group-2">
              <div class="u-container-layout u-valign-middle u-container-layout-7">
                <p class="u-align-center u-custom-font u-font-open-sans u-text u-text-3">
                  <span style="font-weight: 700;"></span>
                  <span 
                  <?php
                    $like = $db->prepare('SELECT id, name, token FROM like_verification WHERE id = ? AND name = ? AND token = ?');
                    $like->execute(array($c['id'], 'pourquoi', $_SESSION['user']));
                    $likes = $like->fetch();
                    $row = $like->rowCount();
                    if($row == 1) {
                      print('style="font-weight: 700; color : #DF1111"');
                    } else {
                      print('style="font-weight: 700; color : #000000"'); 
                    }
                  ?>>
                  <?php
                    $like = $db->prepare('SELECT id, name, number FROM like_number WHERE id = ? AND name = ?');
                    $like->execute(array($c['id'], 'pourquoi'));
                    $likes = $like->fetch();
                    echo $likes['number'];
                  ?>
                  </span>
                </p>
              </div>
            </div>
          </div>
          <div class="u-clearfix u-group-elements u-group-elements-2">
            <a <?php echo "href=like_traitement/bonne_chance.php?page=Pertes&id=".$c['id'];?> class="u-border-none u-btn u-button-style u-custom-color-5 u-btn-7">Bonne chance<br>
            </a>
            <div class="u-container-style u-group u-shape-rectangle u-white u-group-3">
              <div class="u-container-layout u-valign-top u-container-layout-8">
                <p class="u-align-center u-custom-font u-font-open-sans u-text u-text-4">
                  <span style="font-weight: 700;"></span>
                  <span
                  <?php
                    $like = $db->prepare('SELECT id, name, token FROM like_verification WHERE id = ? AND name = ? AND token = ?');
                    $like->execute(array($c['id'], 'bonne_chance', $_SESSION['user']));
                    $likes = $like->fetch();
                    $row = $like->rowCount();
                    if($row == 1) {
                      print('style="font-weight: 700; color : #DF1111"');
                    } else {
                      print('style="font-weight: 700; color : #000000"'); 
                    }
                  ?>>
                  <?php
                    $like = $db->prepare('SELECT id, name, number FROM like_number WHERE id = ? AND name = ?');
                    $like->execute(array($c['id'], 'bonne_chance'));
                    $likes = $like->fetch();
                    echo $likes['number'];
                  ?>
                  </span>
                </p>
              </div>
            </div>
          </div>
          <div class="u-clearfix u-group-elements u-group-elements-3">
            <a <?php echo "href=like_traitement/chaud.php?page=Pertes&id=".$c['id'];?> class="u-btn u-button-style u-custom-color-3 u-btn-8">chaud !</a>
            <div class="u-container-style u-group u-shape-rectangle u-white u-group-4">
              <div class="u-container-layout u-valign-top u-container-layout-9">
                <p class="u-align-center u-custom-font u-font-open-sans u-text u-text-5">
                  <span style="font-weight: 700;"></span>
                  <span 
                  <?php
                    $like = $db->prepare('SELECT id, name, token FROM like_verification WHERE id = ? AND name = ? AND token = ?');
                    $like->execute(array($c['id'], 'chaud', $_SESSION['user']));
                    $likes = $like->fetch();
                    $row = $like->rowCount();
                    if($row == 1) {
                      print('style="font-weight: 700; color : #DF1111"');
                    } else {
                      print('style="font-weight: 700; color : #000000"'); 
                    }
                  ?>>
                  <?php
                    $like = $db->prepare('SELECT id, name, number FROM like_number WHERE id = ? AND name = ?');
                    $like->execute(array($c['id'], 'chaud'));
                    $likes = $like->fetch();
                    echo $likes['number'];
                  ?>
                  </span>
                </p>
              </div>
            </div>
          </div>
          <div class="u-clearfix u-group-elements u-group-elements-4">
            <a <?php echo "href=like_traitement/tu_veux_la_prison.php?page=Pertes&id=".$c['id'];?> class="u-border-none u-btn u-button-style u-custom-color-4 u-btn-9">Tu veux la prison ?</a>
            <div class="u-container-style u-group u-shape-rectangle u-white u-group-5">
              <div class="u-container-layout u-valign-top u-container-layout-10">
                <p class="u-align-center u-custom-font u-font-open-sans u-text u-text-6">
                  <span style="font-weight: 700;"></span>
                  <span                   
                  <?php
                    $like = $db->prepare('SELECT id, name, token FROM like_verification WHERE id = ? AND name = ? AND token = ?');
                    $like->execute(array($c['id'], 'tu_veux_la_prison', $_SESSION['user']));
                    $likes = $like->fetch();
                    $row = $like->rowCount();
                    if($row == 1) {
                      print('style="font-weight: 700; color : #DF1111"');
                    } else {
                      print('style="font-weight: 700; color : #000000"'); 
                    }
                  ?>>
                  <?php
                    $like = $db->prepare('SELECT id, name, number FROM like_number WHERE id = ? AND name = ?');
                    $like->execute(array($c['id'], 'tu_veux_la_prison'));
                    $likes = $like->fetch();
                    echo $likes['number'];
                  ?>
                  </span>
                </p>
              </div>
            </div>
          </div>
          <a <?php echo "href=commentary/Commentaires.php?page=Pertes&id=".$c['id']; ?> class="u-border-none u-btn u-btn-round u-button-style u-hover-palette-1-dark-1 u-palette-1-dark-2 u-radius-30 u-btn-10">commentaires</a>
        </div>
      </div>
      </div>
      <?php }} ?>
    </section>
  </body>
</html>