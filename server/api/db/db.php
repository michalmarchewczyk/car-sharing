<?php

function get_db(){
    try {
        $host = 'db';
        $dbname = 'db';
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
        return new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    }catch(PDOException $ex){
        exit('Database connection error: '.$ex->getMessage());
    }
}

