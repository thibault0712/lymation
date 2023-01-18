<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>
            
            <link rel="icon" type="image/png" href="icone.png">
            <link rel="shortcut icon" href="/icone.png">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <title>Lymation - Inscription</title>
            <meta name="description" content="Lymation est un site internet dédié aux lycéens de Brest ! Son objectif : faire un compte crush en mieux avec des fonctionnalités en plus !">
            <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-NTGKXWK9BZ"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-NTGKXWK9BZ');
        </script>
        </head>
        <body>
        <div class="login-form">
            <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlentities($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> inscription réussie !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'pseudo':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> pseudo non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email trop long
                            </div>
                        <?php 
                        break;

                        case 'pseudo_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> pseudo trop long
                            </div>
                        <?php 
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte deja existant
                            </div>
                        <?php
                        break;
                        case 'space':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> le pseudo ne doit pas contenir des espaces
                            </div>
                        <?php 
                        break;
                        case 'password_lenght':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe trop court (8 charactères minimum)
                            </div>
                        <?php 

                    }
                }
                ?>
            
            <form action="/inscription_traitement.php" method="post">
                <h2 class="text-center">Inscription</h2>       
                <div class="form-group">
                    <input type="text" name="pseudo" class="form-control" placeholder="Pseudo" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" name="password_retype" class="form-control" placeholder="Re-tapez le mot de passe" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Inscription</button>
                </div>   
            </form>
        </div>
        <style>
            .login-form {
                width: 340px;
                margin: 50px auto;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
        </style>
        </body>

        <style>
body{
margin:0;
padding:0;
background: url('/background.jpg') no-repeat center fixed;
-webkit-background-size: cover; /* pour Chrome et Safari */
-moz-background-size: cover; /* pour Firefox */
-o-background-size: cover; /* pour Opera */
background-size: cover; /* version standardisée */
}
</style>
</html>