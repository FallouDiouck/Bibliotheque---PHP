<?php
session_start();

require_once '../../database/user_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['nom']) && 
    !empty($_POST['prenom']) && 
    !empty($_POST['email']) && 
    !empty($_POST['password'])){

        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!getUserByEmail($email)){
        registerUser($nom, $prenom, $email, $password);
        
        header("location: /views/auth/login.php");
        exit();
        } else $_SESSION['error'] = "Cet email existe deja";

} else $_SESSION['error'] = "Veuiller remplir tous les champs";
}

header('location: /views/auth/register.php');
exit();