<?php
session_start();
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

writeLog("Accès à la page brasseur");

// Vérifier si l'utilisateur est admin ou brasseur
checkUserRole(['admin', 'brasseur']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Passerelle</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5deb3; /* Beige doré, couleur bière */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        header {
            background-color: #d2691e; /* Marron moyen, comme une bière brune */
            color: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5em;
            margin: 0;
        }
        .container {
            text-align: center;
            margin-top: 40px;
        }
        h2 {
            font-size: 1.5em;
            margin-bottom: 30px;
            color: #d2691e; /* Marron pour rappeler le thème */
        }
        .blog-links {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .blog-links a {
            text-decoration: none;
            background-color: #f4a300; /* Jaune doré, couleur bière blonde */
            color: #fff;
            font-size: 1.3em;
            padding: 15px 30px;
            margin: 10px 0;
            border-radius: 25px;
            width: 250px;
            text-transform: uppercase;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .blog-links a:hover {
            background-color: #c97c2f; /* Jaune plus foncé pour l'effet hover */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(-3px);
        }
        .blog-links a:active {
            transform: translateY(2px);
        }
        .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 0.9em;
        }
        .logout-btn {
            background-color: #cc0000;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
    <div class="user-info">
        Connecté en tant que: <?php echo htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']); ?> 
        (<?php echo htmlspecialchars($_SESSION['user_role']); ?>)
        <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
    </div>
    <?php endif; ?>

    <header>
        <h1>Bienvenue sur notre page passerelle</h1>
    </header>

    <div class="container">
        <h2>Accédez à nos blogs personnels :</h2>
        <div class="blog-links">
            <a href="brasseurs2.html" target="_blank">Outils de brassage</a>
            <a href="brasseurs3.html" target="_blank">Stock de matière première</a>
            <a href="brasseurs4.html" target="_blank">Stock de produits finis</a>
        </div>
    </div>
</body>
</html>