<?php
    session_start();
    session_destroy();
    setcookie('auto_log');
    unset($_COOKIE['auto_log']);
    header('Location:/index.php');
?>