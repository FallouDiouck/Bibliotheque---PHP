<?php

require_once 'db_connection.php';

function getUserByEmail($email){
    global $connexion;
    $sql = "SELECT * FROM  users WHERE email = :email";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    return $stmt->fetch();
}

function getUserByRole($role){
    global $connexion;
    $sql = "SELECT * FROM  users WHERE role = :role";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function registerUser($nom, $prenom, $email, $password){
    global $connexion;
    $sql = "INSERT INTO users (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $passwordHash);
    
    return $stmt->execute();
}

function getUserById($id){
    global $connexion;
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    return $stmt->fetch();
}

function updateUser($id, $nom, $prenom, $email, $password = null){
    global $connexion;
    if($password){
        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, password = :password WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT));
    }else{
        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id";
        $stmt = $connexion->prepare($sql);
    }
    
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    
    return $stmt->execute();
}

function updatePassword($id, $password){
    global $connexion;
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT));
    
    return $stmt->execute();
}