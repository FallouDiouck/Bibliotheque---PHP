<?php
require_once 'livre_db.php';
require_once 'db_connection.php';

function getEmpruntByUser($user_id) {
    global $connexion;
    $sql = "SELECT e.*, l.titre as titre_livre 
            FROM emprunts e
            JOIN livres l ON e.livre_id = l.id
            WHERE e.user_id = :user_id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function getEmpruntById($emprunt_id) {
    global $connexion;
    $sql = "SELECT * FROM emprunts WHERE id = :emprunt_id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':emprunt_id', $emprunt_id);
    $stmt->execute();
    
    return $stmt->fetch();
}

function addEmprunt($user_id, $livre_id, $date_emprunt) {
    global $connexion;
    $sql = "INSERT INTO emprunts (user_id, livre_id, date_emprunt) VALUES (:user_id, :livre_id, :date_emprunt)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':livre_id', $livre_id);
    $stmt->bindParam(':date_emprunt', $date_emprunt);
 
    
    return $stmt->execute();
}
function getEmpruntByLivreIdAndUserId($livre_id, $user_id, $statut = 'en cours') {
    global $connexion;
    $sql = "SELECT * FROM emprunts WHERE livre_id = :livre_id AND user_id = :user_id AND statut = :statut";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':livre_id', $livre_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':statut', $statut);
    $stmt->execute();
    
    return $stmt->fetch();
}

function updateEmprunt($emprunt_id, $livre_id, $user_id, $date_emprunt, $date_retour, $statut = 'retourné') {
    global $connexion;
    $sql = "UPDATE emprunts SET livre_id = :livre_id, user_id = :user_id, date_emprunt = :date_emprunt, date_retour = :date_retour, statut = :statut WHERE id = :emprunt_id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':emprunt_id', $emprunt_id);
    $stmt->bindParam(':livre_id', $livre_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':date_emprunt', $date_emprunt);
    $stmt->bindParam(':date_retour', $date_retour);
    $stmt->bindParam(':statut', $statut);
    
    return $stmt->execute();
}