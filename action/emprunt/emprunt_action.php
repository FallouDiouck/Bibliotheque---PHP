<?php
session_start();

require_once '../../database/emprunt_db.php';
require_once '../../database/livre_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['livre_id'])){
        $livre = getLivreById($_POST['livre_id']);
        if($livre['nbr_livre'] <= 0){
            $_SESSION['error'] = "Ce livre n'est pas disponible pour le moment.";
            header('location: /index.php');
            exit();
        }
        $livre_id = $_POST['livre_id'];
        $user_id = $_SESSION['user_id'];
        $date_emprunt = date('Y-m-d');
        

        if(getEmpruntByLivreIdAndUserId($livre_id, $user_id, 'en_cours')){
            $_SESSION['error'] = "Vous avez déjà emprunté ce livre.";
            header('location: /index.php');
            exit();
        }else{
            $livre['nbr_livre'] -= 1;
            
            updateLivre($livre_id, $livre['titre'], $livre['auteur'], $livre['annee'], $livre['nbr_livre'], $livre['categorie_id']);
            addEmprunt($user_id, $livre_id, $date_emprunt);
            $_SESSION['success'] = "Livre emprunté avec succès.";
            header('location: /views/Emprunts/livre_emprunte.php');
            exit();
        }
    }else{
        $_SESSION['error'] = "Livre non spécifié.";
    }
}
header('location: /index.php');
exit();