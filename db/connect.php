<?php

class Connect_DB {
    function connect() {
        $servername = "localhost";
        $username = "root";
        $password = "root";

        try {
            $db = new PDO("mysql:host=$servername;dbname=auth", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            return false;
        }
    }
}
