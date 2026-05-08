<?php

require_once 'db_connection.php';

function addReservation($user_id, $livre_id){

    global $connexion;
    $sql = "INSERT INTO reservations (user_id, livre_id) VALUES (:user_id, :livre_id)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':livre_id', $livre_id);
    
    return $stmt->execute();
}

function getReservationsByUserId($user_id){
    global $connexion;
    $sql = "SELECT r.*, l.titre, l.auteur FROM reservations r JOIN livres l ON r.livre_id = l.id WHERE r.user_id = :user_id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function getReservationByStatus($livre_id, $status){
    global $connexion;
    $sql = "SELECT r.*, l.titre, l.auteur FROM reservations r JOIN livres l ON r.livre_id = l.id WHERE r.livre_id = :livre_id AND r.statut = :status";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':livre_id', $livre_id);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function updateReservation($id, $statut){
    global $connexion;
    $sql = "UPDATE reservations SET statut = :statut WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':statut', $statut);
    
    return $stmt->execute();
}

function getActiveReservation($user_id, $livre_id){
    global $connexion;
    $sql = "SELECT * FROM reservations WHERE user_id = :user_id AND livre_id = :livre_id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':livre_id', $livre_id);
    $stmt->execute();
    
    return $stmt->fetch();
}

function getReservationsById($id){
    global $connexion;
    $sql = "SELECT * FROM reservations WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    return $stmt->fetch();
}