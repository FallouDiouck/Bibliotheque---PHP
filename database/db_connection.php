<?php
$host = 'localhost';
$user = 'root';
$db_name = 'biblio';
$password = '';

try{
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
    $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $connexion = new PDO($dsn, $user, $password, $option);
    //die("Connexion à la base de données réussie !");
}catch(PDOException $e){
    die("Erreur de connexion à la base de données : " . $e->getMessage());

}