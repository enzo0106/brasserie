<?php
// Démarrer la session
session_start();

require_once 'panier.php'; 

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Vérifier si les données nécessaires sont présentes
if (isset($_POST['produit_id'], $_POST['produit_nom'], $_POST['produit_prix'], $_POST['quantite'])) {
    $produit_id = (int)$_POST['produit_id'];
    $produit_nom = $_POST['produit_nom'];
    $produit_prix = (float)$_POST['produit_prix'];
    $quantite = (int)$_POST['quantite'];
    
    // Vérifier si la quantité est valide
    if ($quantite < 1) {
        http_response_code(400);
        echo "Quantité invalide";
        exit;
    }
    
    // Vérifier si le produit existe déjà dans le panier
    $produit_existe = false;
    foreach ($_SESSION['panier'] as $key => $item) {
        if ($item['id'] == $produit_id) {
            // Mettre à jour la quantité
            $_SESSION['panier'][$key]['quantite'] += $quantite;
            $produit_existe = true;
            break;
        }
    }
    
    // Si le produit n'existe pas dans le panier, l'ajouter
    if (!$produit_existe) {
        $_SESSION['panier'][] = [
            'id' => $produit_id,
            'nom' => $produit_nom,
            'prix' => $produit_prix,
            'quantite' => $quantite
        ];
    }
    
    // Calculer le nombre total d'articles dans le panier
    $nombre_articles = 0;
    foreach ($_SESSION['panier'] as $item) {
        $nombre_articles += $item['quantite'];
    }
    
    // Renvoyer le nombre d'articles pour mettre à jour le compteur
    echo $nombre_articles;
} else {
    // Si les données sont manquantes, renvoyer une erreur
    http_response_code(400);
    echo "Données manquantes";
}
?>