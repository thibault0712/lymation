<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=Nom_Base_De_Donnée;charset=utf8', 'Identifiant', 'MDPSecure');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
