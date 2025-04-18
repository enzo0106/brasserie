<?php
session_start();
require_once 'config_admin.php'; 
$error = "";





// Vérification du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifier si l'email existe
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Vérification du mot de passe
        if (password_verify($password, $user['mot_de_passe'])) {
            // Connexion réussie, création de la session
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            // Écrire dans le fichier de logs
            $date = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $logMessage = "[$date] - IP: $ip - Utilisateur: {$user['email']} - Action: Connexion réussie (Rôle: {$user['role']})\n";
            file_put_contents(__DIR__ . '/logs.tkt', $logMessage, FILE_APPEND);

            // Redirection selon le rôle
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'brasseur':
                    header("Location: brasseur.php");
                    break;
                case 'caissier':
                    header("Location: caissier.php");
                    break;
                case 'direction':
                    header("Location: direction.php");
                    break;
                case 'client':
                    header("Location: client.php");
                    break;
                default:
                    header("Location: index.html");
            }
            exit;
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Cet email n'existe pas dans notre base de données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Brasserie Terroir et Saveurs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5dc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fffaf0;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #5c4033;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #8b7765;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d2b48c;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #deb887;
            color: white;
            padding: 14px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #c19a6b;
        }
        .error {
            color: #cc0000;
            margin-top: 15px;
            font-size: 14px;
        }
        .links {
            margin-top: 20px;
        }
        .links a {
            color: #8b7765;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="src/brasserie_logo.png" alt="Logo Brasserie" class="logo">
        <h2>Connexion</h2>
        
        <form method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Votre adresse email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
            </div>
            
            <button type="submit" class="btn">Se connecter</button>
            
            <?php if (!empty($error)): ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>
        </form>
        
        <div class="links">
            <a href="index.html">Retour à l'accueil</a>
            <a href="page_v.html">Voir nos produits</a>
        </div>
    </div>
</body>
</html>