<?php
session_start();
require_once 'config_admin.php';
require_once 'auth_check.php';

function writeLog($action) {
    try {
        $date = date('Y-m-d H:i:s');
        $user = isset($_SESSION['email']) ? $_SESSION['email'] : 'Utilisateur inconnu';
        $ip = $_SERVER['REMOTE_ADDR'];
        $logMessage = "[$date] - IP: $ip - Utilisateur: $user - Action: $action\n";

        $logFile = __DIR__ . '/logs.tkt';
        if (file_put_contents($logFile, $logMessage, FILE_APPEND) === false) {
            error_log("Impossible d'écrire dans le fichier de logs: $logFile");
        }
    } catch (Exception $e) {
        error_log("Erreur lors de l'écriture des logs: " . $e->getMessage());
    }
}

writeLog("Accès à la page caissier");

// Vérification si l'utilisateur est bien caissier
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'caissier') {
    header("Location: acces_refuser.php");
    exit;
}

// Récupération des clients
$stmt = $pdo->prepare("SELECT id, nom, prenom FROM utilisateurs WHERE role = 'client'");
$stmt->execute();
$clients = $stmt->fetchAll();

// Récupération des produits
$stmt = $pdo->query("SELECT * FROM produits");
$produits = $stmt->fetchAll();

// Récupération des commandes
$stmt = $pdo->query("SELECT c.id, c.date_commande, c.total, c.statut, u.nom, u.prenom FROM commandes c JOIN utilisateurs u ON c.client_id = u.id ORDER BY c.date_commande DESC");
$commandes = $stmt->fetchAll();

// Traitement de la vente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider_vente'])) {
    $client_id = $_POST['client_id'];
    $produits_choisis = $_POST['produits'];
    $total = 0;

    foreach ($produits_choisis as $produit_id => $quantite) {
        $stmt = $pdo->prepare("SELECT prix, stock FROM produits WHERE id = ?");
        $stmt->execute([$produit_id]);
        $produit = $stmt->fetch();

        if ($produit && $quantite > 0 && $produit['stock'] >= $quantite) {
            $total += $produit['prix'] * $quantite;

            // Mise à jour du stock
            $stmt = $pdo->prepare("UPDATE produits SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$quantite, $produit_id]);
        }
    }

    if (isset($_POST['ajouter_client'])) {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, role, points_fidelite) VALUES (?, ?, ?, 'client', 0)");
        $stmt->execute([$_POST['nom'], $_POST['prenom'], $_POST['email']]);
        header("Location: caissier.php");
        exit;
    }

    // Enregistrement de la vente
    $stmt = $pdo->prepare("INSERT INTO ventes (caissier_id, client_id, total) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $client_id, $total]);

    $message = "Vente enregistrée avec succès. Total : $total €";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface Caissier</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 10px; max-width: 800px; margin: auto; }
        h1 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        label, select, input, button { width: 100%; padding: 8px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Système de Caisse</h1>

        <?php if (isset($message)): ?>
            <p style="color: green;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="client_id">Choisir un client :</label>
                <select name="client_id" id="client_id" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h3>Ajouter des produits :</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix (€)</th>
                        <th>Stock</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?= htmlspecialchars($produit['nom']) ?></td>
                            <td><?= htmlspecialchars($produit['prix']) ?></td>
                            <td><?= htmlspecialchars($produit['stock']) ?></td>
                            <td>
                                <input type="number" name="produits[<?= $produit['id'] ?>]" min="0" max="<?= $produit['stock'] ?>" value="0">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit" name="valider_vente">Valider la vente</button>
            
        </form>
        <div class="flex">
        <!-- Ajout client -->
        <div class="section">
            <h2>Ajouter un Client</h2>
            <form method="post">
                <div class="form-group"><label>Nom</label><input type="text" name="nom" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" name="prenom" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <button type="submit" name="ajouter_client">Ajouter Client</button>
            </form>
        </div>
    </div>

    <h3>Commandes des clients :</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Date</th>
                <th>Total (€)</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= htmlspecialchars($commande['id']) ?></td>
                    <td><?= htmlspecialchars($commande['prenom'] . ' ' . $commande['nom']) ?></td>
                    <td><?= htmlspecialchars($commande['date_commande']) ?></td>
                    <td><?= htmlspecialchars($commande['total']) ?></td>
                    <td><?= htmlspecialchars($commande['statut']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
