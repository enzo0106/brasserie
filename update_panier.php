<?php
// Démarrer la session
session_start();

require_once 'panier.php'; 

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Vérifier si les données nécessaires sont présentes
if (isset($_POST['index'], $_POST['quantite'])) {
    $index = (int)$_POST['index'];
    $quantite = (int)$_POST['quantite'];
    
    // S'assurer que la quantité est valide
    if ($quantite < 1) {
        $quantite = 1;
    }
    
    // Mettre à jour la quantité si l'élément existe
    if (isset($_SESSION['panier'][$index])) {
        $_SESSION['panier'][$index]['quantite'] = $quantite;
        echo "success";
    } else {
        http_response_code(400);
        echo "Produit non trouvé dans le panier";
    }
} else {
    // Si les données sont manquantes, renvoyer une erreur
    http_response_code(400);
    echo "Données manquantes";
}
?>