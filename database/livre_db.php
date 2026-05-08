<?php

require_once 'db_connection.php';

function getAllLivres(){
    global $connexion;
    $sql = "SELECT l.*, c.nom as categorie_nom 
            FROM livres l
            JOIN categories c 
            ON l.categorie_id = c.id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function getLivreById($id){
    global $connexion;
    $sql = "SELECT l.*, c.nom as categorie_nom 
            FROM livres l
            JOIN categories c ON l.categorie_id = c.id
            WHERE l.id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    return $stmt->fetch();
}

function getLivreByTitre($titre){
    global $connexion;
    $sql = "SELECT * FROM livres WHERE titre = :titre";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':titre', $titre);
    $stmt->execute();
    
    return $stmt->fetch();
}

function addLivres($titre, $auteur, $annee, $nbr_livre, $categorie_id){
    global $connexion;
    $sql = "INSERT INTO livres (titre, auteur, annee, nbr_livre, categorie_id) VALUES (:titre, :auteur, :annee, :nbr_livre, :categorie_id)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':auteur', $auteur);
    $stmt->bindParam(':annee', $annee);
    $stmt->bindParam(':nbr_livre', $nbr_livre);
    $stmt->bindParam(':categorie_id', $categorie_id);
    
    return $stmt->execute();
}

function getLivreByCategorie($categorie_id){
    global $connexion;
    $sql = "SELECT l.*, c.nom as categorie_nom 
            FROM livres l
            JOIN categories c ON l.categorie_id = c.id
            WHERE l.categorie_id = :categorie_id ";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':categorie_id', $categorie_id);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function updateLivre($id, $titre, $auteur, $annee, $nbr_livre, $categorie_id){
    global $connexion;
    $sql = "UPDATE livres SET titre = :titre, auteur = :auteur, annee = :annee, nbr_livre = :nbr_livre, categorie_id = :categorie_id WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':auteur', $auteur);
    $stmt->bindParam(':annee', $annee);
    $stmt->bindParam(':nbr_livre', $nbr_livre);
    $stmt->bindParam(':categorie_id', $categorie_id);
    
    return $stmt->execute();
}

function searchLivres($searchTerm){
    global $connexion;
    $sql = "SELECT l.*, c.nom as categorie_nom 
            FROM livres l
            JOIN categories c ON l.categorie_id = c.id
            WHERE l.titre LIKE :searchTerm OR l.auteur LIKE :searchTerm";
    $stmt = $connexion->prepare($sql);
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bindParam(':searchTerm', $likeTerm);
    $stmt->execute();
    
    return $stmt->fetchAll();
}