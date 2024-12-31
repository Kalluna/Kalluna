<?php

$server = "localhost";
$user = "root";
$password = "";
$dbname = "todoList";
$tableName = "task";

$connection = new mysqli($server , $user, $password);

if($connection->connect_error){
    die("connection Falied ". $connection->connect_error);
}

    function CreateDb($dbname, $connection){
        $createDbSql = "CREATE DATABASE IF NOT EXISTS $dbname " ;
        if($connection->query($createDbSql) === TRUE){
            echo "Datbase created successfully";
        }
        else{
            echo "Falied to create Database: ".$connection->connect_error;
        }

    }
    
    function Createtable($tableName, $connection, $dbname){
        $connection->select_db($dbname);
        $createtableSql = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Task VARCHAR(255) NOT NULL
        ) " ;
        if($connection->query($createtableSql) === TRUE){
            echo "Table created successfully";
        }
        else{
            echo "Falied to create Table: ".$connection->connect_error;
        }
        
    }
    CreateDb($dbname, $connection);
    Createtable($tableName, $connection, $dbname);

?>