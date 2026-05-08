<?php
session_start();

require_once '../../database/user_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
        $user_id = $_SESSION['user_id'];
        $current_password = $_POST['current_password'];
        $password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];


        if(password_verify($current_password, getUserById($user_id)['password'])){
            if($password === $confirm_password){
                updatePassword($user_id, $password);
            header("location: /views/profil/profil.php");
            exit();
        }$_SESSION['error'] = "Les mots de passe ne correspondent pas";
        }$_SESSION['error'] = "Mot de passe actuel incorrect";
    }$_SESSION['error'] = "Veuiller remplir tous les champs";
}
header('location: /views/profil/changer_mdp.php');
exit();