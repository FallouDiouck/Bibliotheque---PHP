<?php

require_once 'db_connection.php';

function getAllCategories(){
    global $connexion;
    $sql = "SELECT * FROM categories";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll();
}