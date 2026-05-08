<?php
session_start();

require_once '../../database/user_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['nom']) && 
    !empty($_POST['prenom']) && 
    !empty($_POST['email']) ){

        $id = $_POST['user_id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        updateUser($id, $nom, $prenom, $email, $password);
        $_SESSION['success'] = "Votre profil a été mis à jour avec succès.";
        header("location: /views/profil/profil.php");
        exit();
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    }
}