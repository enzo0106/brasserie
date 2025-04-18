<?php
session_start();

// Enregistrer la déconnexion dans les logs si l'utilisateur était connecté
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    $date = date('Y-m-d H:i:s');
    $user = isset($_SESSION['email']) ? $_SESSION['email'] : 'Utilisateur inconnu';
    $ip = $_SERVER['REMOTE_ADDR'];
    $logMessage = "[$date] - IP: $ip - Utilisateur: $user - Action: Déconnexion\n";
    file_put_contents(__DIR__ . '/logs.tkt', $logMessage, FILE_APPEND);
}

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil
header("Location: index.html");
exit;