<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=xetjthqa_lymation;charset=utf8', 'xetjthqa_Vupilex', 'Stjoyrhup@29');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }