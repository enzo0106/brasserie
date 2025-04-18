<?php
session_start();
// Vérification que l'utilisateur est un admin (ajoutez votre propre logique d'authentification si nécessaire)
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit;
// }

// Lire le contenu du fichier de logs
$logsFile = __DIR__ . '/logs.tkt';
$logsContent = file_exists($logsFile) ? file_get_contents($logsFile) : 'Aucun log disponible.';
$logsArray = explode("\n", $logsContent);
$logsArray = array_filter($logsArray); // Enlever les lignes vides

// Si demande de téléchargement
if (isset($_GET['download'])) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="logs.txt"');
    echo $logsContent;
    exit;
}

// Si demande de vider les logs
if (isset($_GET['clear']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents($logsFile, '');
    header('Location: view_logs.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisation des logs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5dc; 
            color: #333;
            margin: 0;
            padding: 0;
        }   
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fffaf0; 
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        h1 {
            text-align: center;
            color: #5c4033; 
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px 5px;
            background-color: #deb887; 
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #d2b48c;
        }
        .btn-danger {
            background-color: #d9534f;
        }
        .btn-danger:hover {
            background-color: #c9302c;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .logs-container {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            max-height: 500px;
            overflow-y: auto;
            font-family: monospace;
            white-space: pre-wrap;
            line-height: 1.5;
        }
        .log-entry {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .log-entry:nth-child(odd) {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Logs d'administration</h1>
        
        <div class="actions">
            <a href="admin.php" class="btn">Retour au panneau d'administration</a>
            <div>
                <a href="view_logs.php?download=1" class="btn">Télécharger les logs</a>
                <form method="post" action="view_logs.php?clear=1" style="display:inline;">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir vider les logs ?');">Vider les logs</button>
                </form>
            </div>
        </div>
        
        <div class="logs-container">
            <?php if (empty($logsArray)): ?>
                <p>Aucun log disponible.</p>
            <?php else: ?>
                <?php foreach($logsArray as $log): ?>
                    <div class="log-entry"><?= htmlspecialchars($log) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>