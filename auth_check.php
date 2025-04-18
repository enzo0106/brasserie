<?php
session_start();

// Fonction pour vérifier si l'utilisateur est connecté et a le bon rôle
function checkUserRole($allowed_roles = []) {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        // Redirection vers la page de connexion
        header("Location: connexion.php");
        exit;
    }
    
    // Si aucun rôle spécifique n'est requis, on autorise l'accès
    if (empty($allowed_roles)) {
        return true;
    }
    
    // Vérifier si le rôle de l'utilisateur est dans la liste des rôles autorisés
    if (in_array($_SESSION['user_role'], $allowed_roles)) {
        return true;
    } else {
        // Redirection vers une page d'erreur ou d'accueil
        header("Location: acces_refuse.php");
        exit;
    }
}