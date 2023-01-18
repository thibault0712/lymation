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

    //Parti génération

      $article = $db->prepare('SELECT * FROM tout WHERE id ORDER BY id DESC');
      $article->execute();
?>

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
  <link rel="icon" type="image/png" href="icone.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Lymation - Publier</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Publier.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.7.1, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,200,300,400,500,600,700,800,900">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Publier">
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
  <body class="u-body u-xl-mode"><header class="u-clearfix u-header u-palette-1-dark-1 u-header" id="sec-4ebf"><a href="../Tout.php" class="u-border-none u-btn u-button-style u-hover-palette-1-light-1 u-palette-1-dark-1 u-btn-1"><span class="u-file-icon u-icon u-text-white u-icon-1"></span>&nbsp;
      </a><p class="u-align-center u-custom-font u-font-roboto-slab u-text u-text-1">
        <span style="font-size: 2.25rem; font-weight: 700;">Publier</span>
        <br>
      </p>
    </header>
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
                                <strong>Erreur</strong> Votre message est trop long (taille maximale 500 caractères).
                            </div>
                        <?php
                        break;

                        case 'unknown':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> inconnue...
                            </div>
                        <?php 
                        break;
                        
                        case 'date':
                          ?>
                              <div class="alert alert-danger">
                                  <strong>Erreur</strong> vous devez attendre 30 minutes entre chaque publication !
                              </div>
                          <?php
                          break;
                          
                        case 'notwriten':
                          ?>
                              <div class="alert alert-danger">
                                  <strong>Erreur</strong> veuillez remplir tous les champs
                              </div>
                          <?php
                          break;

                    }
                }
      ?>
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-expanded-width-xs u-form u-form-1">
          <form action="publier_traitement.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 10px;" redirect="true">
            <div class="u-form-group u-form-select u-form-group-1">
              <label for="select-30f4" class="u-label">Cathégorie</label>
              <div class="u-form-select-wrapper">
                <select id="select-30f4" name="cathegorie" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                  <option value="crush">Crush</option>
                  <option value="pertes">Pertes</option>
                  <option value="betises">Drôle</option>
                  <option value="autres">Autres</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>
            <div class="u-form-group u-form-message">
              <label for="message-0f12" class="u-label">Message</label>
              <textarea placeholder="Entrez votre message" rows="4" cols="50" id="message-0f12" name="message" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required=""></textarea>
            </div>
            <div class="u-form-checkbox u-form-group u-form-group-3">
              <input type="checkbox" id="checkbox-ec00" name="checkbox" value="Anonyme" checked>
              <label for="checkbox-ec00" class="u-label">Anonyme<br>
              </label>
            </div>
            <div class="u-align-center u-form-group u-form-submit">
              <a href="#" class="u-btn u-btn-submit u-button-style">Publier</a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>
            <div class="u-form-send-message u-form-send-success"></div>
            <div class="u-form-send-error u-form-send-message"></div>
            <input type="hidden" value="" name="recaptchaResponse">
          </form>
        </div>
      </div>
    </section>
  </body>
</html>