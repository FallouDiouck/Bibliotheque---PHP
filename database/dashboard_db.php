<?php


require_once 'db_connection.php';

function getTotalLivres() {
    global $connexion;
    $stmt = $connexion->query("SELECT COUNT(*) FROM livres");
    return $stmt->fetchColumn();
}

function getTotalAdherents() {
    global $connexion;
    $stmt = $connexion->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
    return $stmt->fetchColumn();
}

function getTotalEmprunts() {
    global $connexion;
    $stmt = $connexion->query("SELECT COUNT(*) FROM emprunts");
    return $stmt->fetchColumn();
}

function getEmpruntsEnCours() {
    global $connexion;
    $stmt = $connexion->query("SELECT COUNT(*) FROM emprunts WHERE date_retour IS NULL");
    return $stmt->fetchColumn();
}

function getEmpruntsEnRetard() {
    global $connexion;
    $stmt = $connexion->query("SELECT COUNT(*) FROM emprunts WHERE date_retour IS NULL AND DATE_ADD(date_emprunt, INTERVAL 7 DAY) < CURDATE()");
    return $stmt->fetchColumn();
}

function getLivresDisponibles() {
    global $connexion;
    $stmt = $connexion->query("SELECT COUNT(*) FROM livres WHERE nbr_livre > 0");
    return $stmt->fetchColumn();
}

function getEmpruntsParMois() {
    global $connexion;
    $stmt = $connexion->query("
        SELECT DATE_FORMAT(date_emprunt, '%b %Y') as mois,
               DATE_FORMAT(date_emprunt, '%Y-%m') as mois_tri,
               COUNT(*) as total
        FROM emprunts
        WHERE date_emprunt >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY mois, mois_tri
        ORDER BY mois_tri ASC
    ");
    return $stmt->fetchAll();
}

function getTopLivres() {
    global $connexion;
    $stmt = $connexion->query("
        SELECT l.titre, l.auteur, COUNT(e.id) as nb_emprunts
        FROM emprunts e
        JOIN livres l ON e.livre_id = l.id
        GROUP BY l.id, l.titre, l.auteur
        ORDER BY nb_emprunts DESC
        LIMIT 5
    ");
    return $stmt->fetchAll();
}

function getDerniersEmprunts() {
    global $connexion;
    $stmt = $connexion->query("
        SELECT u.nom, u.prenom, l.titre, e.date_emprunt, e.date_retour,
               DATE_ADD(e.date_emprunt, INTERVAL 7 DAY) as date_limite
        FROM emprunts e
        JOIN users u ON e.user_id = u.id
        JOIN livres l ON e.livre_id = l.id
        ORDER BY e.date_emprunt DESC
        LIMIT 8
    ");
    return $stmt->fetchAll();
}

function getLivresParCategorie() {
    global $connexion;
    $stmt = $connexion->query("
        SELECT c.nom, COUNT(l.id) as total
        FROM livres l
        JOIN categories c ON l.categorie_id = c.id
        GROUP BY c.id, c.nom
        ORDER BY total DESC
    ");
    return $stmt->fetchAll();
}