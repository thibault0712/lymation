<?php
    session_start();
    session_destroy();
    setcookie('auto_log', NULL, -1); //Permet la suppression du cookie pour la version de dev
    setcookie('auto_log', NULL, -1, "/", "lymation.pq.lu", true, true); //Permet la suppression du cookie pour la vraie version
    header('Location:/index.php');
?>