<?php
session_start();

require_once '../../database/reservation_db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['reservation_id']) && isset($_SESSION['user_id'])){

        $reservation_id = $_POST['reservation_id'];
        $user_id = $_SESSION['user_id'];

        $reservation = getReservationById($reservation_id);
        if($reservation && $reservation['user_id'] === $user_id){
            updateReservation($reservation_id, 'annulée');
            $_SESSION['success'] = "Réservation annulée avec succès.";
            header('location: /views/reservations/mes_reservations.php');
            exit();
        } else {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à annuler cette réservation.";
        }
    } else {
        $_SESSION['error'] = "Erreur lors de l'annulation de la réservation. Veuillez réessayer.";
    }
}