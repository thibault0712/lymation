<?php
    try {
        $db = new PDO('mysql:host=127.0.0.1:3400;dbname=xetjthqa_lymation;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
