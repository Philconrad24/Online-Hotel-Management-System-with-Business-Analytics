<?php

    function establishCONN() {
        // dev_db
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=reservation', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }  
?>