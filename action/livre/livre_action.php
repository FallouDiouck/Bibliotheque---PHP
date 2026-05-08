<?php
session_start();

require_once '../../database/livre_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['titre']) && 
    !empty($_POST['auteur']) && 
    !empty($_POST['annee'])
     && !empty($_POST['categorie_id'])){

        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $annee = $_POST['annee'];
        $nbr_livre = $_POST['nbr_livre'] ?? 0;
        $categorie_id = $_POST['categorie_id'];
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            updateLivre($id, $titre, $auteur, $annee, $nbr_livre, $categorie_id);
            $_SESSION['success'] = "Livre mis à jour avec succès";
            header("location: /views/livres/livre.php");
            exit();
        }
        else if(!getLivreByTitre($titre)){
           if(addLivres($titre, $auteur, $annee, $nbr_livre, $categorie_id)){
                $_SESSION['success'] = "Livre ajouté avec succès";
                header("location: /views/livres/livre.php");
                exit();
            }
        }
        else {
            $_SESSION['error'] = "Ce titre de livre existe deja";
        }
    }
    $_SESSION['error'] = "Veuiller remplir tous les champs";
}
header('location: /views/livres/livre_form.php');
exit();