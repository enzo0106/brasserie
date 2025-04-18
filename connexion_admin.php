<?php
session_start();
require_once 'config_admin.php'; 


$error = "";

//ici c'est une Vérification du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);



    //ici on vas Vérifier si l'email existe et si c'est un administrateur
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email AND role = 'admin'");
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch();

    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        // Si l'administrateur est déjà connecté, on le redirige vers la page d'administration
            
            header("location: http://brasserie-terroir-et-saveurs.great-site.net/admin.php");
            
       
    }

    if ($admin && password_verify($password, $admin['mot_de_passe'])) {
        //  Connexion réussie, création de la session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nom'] = $admin['nom'];
        $_SESSION['admin_prenom'] = $admin['prenom'];
        header("location: http://brasserie-terroir-et-saveurs.great-site.net/admin.php");
        exit;
    } else {
        $error = "Identifiants incorrects ou accès refusé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5dc;
            text-align: center;
        }
        .login-container {
            background-color: #fffaf0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            margin: 100px auto;
        }
        h2 {
            color: #5c4033;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #deb887;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;

            cursor: pointer;
        }
        .btn:hover {
            background-color: #d2b48c;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion Administrateur</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" class="btn">Se connecter</button>
        </form>
        <?php if (!empty($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
