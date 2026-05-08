<?php
session_start();

require_once '../../database/reservation_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['livre_id']) && isset($_SESSION['user_id'])){

        $user_id = $_SESSION['user_id'];
        $livre_id = $_POST['livre_id'];

        if(!getReservationByStatus($livre_id, 'en attente') && !getActiveReservation($user_id, $livre_id)){
            addReservation($user_id, $livre_id);
            $_SESSION['success'] = "Livre réservé avec succès.";
            header('location: /views/reservations/mes_reservations.php');
            exit();
        } else {
            $_SESSION['error'] = "Ce livre est déjà réservé. Réessayez ultérieurement.";
        }
    } else {
        $_SESSION['error'] = "Erreur lors de la réservation du livre. Veuillez réessayer.";
    }
}
header('location: /index.php');
exit();