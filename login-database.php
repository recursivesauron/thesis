<?php

function connectToDatabase(){
    $hostname="localhost";
    $uname="web-thesis";
    $password="P4nZ3RpR0jeCt:)";
    $db_name = "thesis";
      
    try {
        $db = new PDO("mysql:host=".$hostname.";dbname=".$db_name.";port=3306",$uname, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES 'utf8'");
    } catch (Exception $e) {
        echo("Could not connect to the database.");
        exit();
    }

    return $db;
}

?>