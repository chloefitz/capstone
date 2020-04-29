<?php
    ini_set ( 'display_errors', 1 ); // let me learn from my mistakes!
    error_reporting ( E_ALL | E_STRICT ); // Show all possible problems.

    // intialize variables
    $dsn = 'mysql:host=localhost;dbname=capstone';
    $username = 'root';
    $password = '';
    $e = '';
        
        
    // Create database object and catch exceptions
    try{
        $cnxn = new PDO ($dsn, $username, $password);
        echo ("Connected.<br />");
        } 
    catch (PDOException $e){
            $errorMessage = $e->getMessage();
            echo ("Error connecting to database: $errorMessage <br />");
            
        }
?>