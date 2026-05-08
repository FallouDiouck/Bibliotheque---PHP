<?php
session_start();

require_once '../../database/emprunt_db.php';
require_once '../../database/livre_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['id']) && !empty($_POST['livre_id'])){
        $emprunt_id = $_POST['id'];
        $livre_id = $_POST['livre_id'];
        
        $emprunt = getEmpruntById($emprunt_id);
        if($emprunt){
            updateEmprunt($emprunt_id, $emprunt['livre_id'], $emprunt['user_id'], $emprunt['date_emprunt'], date('Y-m-d'), 'retourné');
            $livre = getLivreById($livre_id);
            if($livre){
                $livre['nbr_livre'] += 1;
                updateLivre($livre_id, $livre['titre'], $livre['auteur'], $livre['annee'], $livre['nbr_livre'], $livre['categorie_id']);
            }
            header('location: /views/Emprunts/livre_emprunte.php');
            exit();
        }

        }else{
            $_SESSION['error'] = "Emprunt non trouvé.";
        }
        
    }else{
        $_SESSION['error'] = "Données d'emprunt manquantes.";
    }
header('location: /views/Emprunts/livre_emprunte.php');
exit();