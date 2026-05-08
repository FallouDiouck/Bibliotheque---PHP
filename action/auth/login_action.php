<?php
session_start();
require '../../database/user_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['email']) && 
    !empty($_POST['password'])){

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = getUserByEmail($email);
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            header('location: /index.php');
            exit();
        }else $_SESSION['error'] = "Email ou mot de passe incorrect";

    }else $_SESSION['error'] = "Veuiller remplir tous les champs";
}
header('location: /views/auth/login.php');
exit();