<?php
session_start();
$role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'non connecté';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Refusé</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5dc;
            text-align: center;
            padding: 50px 20px;
            color: #5c4033;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fffaf0;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #cc0000;
        }
        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background-color: #deb887;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #c19a6b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Accès Refusé</h1>
        <p>Désolé, vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
        <p>Votre rôle actuel : <strong><?php echo htmlspecialchars($role); ?></strong></p>
        
        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
            <p>Vous pouvez retourner à la page correspondant à votre rôle:</p>
            <?php 
                $redirect_url = '';
                switch ($_SESSION['user_role']) {
                    case 'admin':
                        $redirect_url = 'admin.php';
                        break;
                    case 'brasseur':
                        $redirect_url = 'brasseur.html';
                        break;
                    case 'caissier':
                        $redirect_url = 'caissier.php';
                        break;
                    default:
                        $redirect_url = 'connexion_client'; // Pour les clients et autres
                }
            ?>
            <a href="<?php echo $redirect_url; ?>" class="btn">Retour à votre page</a>
        <?php else: ?>
            <a href="connexion.php" class="btn">Se connecter</a>
        <?php endif; ?>
        
        <p><a href="index.html">Retour à l'accueil</a></p>
    </div>
</body>
</html>