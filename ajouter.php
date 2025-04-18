<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = :email");
    $checkEmail->bindValue(':email', $email, PDO::PARAM_STR);
    $checkEmail->execute();

    if ($checkEmail->fetchColumn() > 0) {
        echo "Erreur : cet email est déjà utilisé.";
        exit;
    }

    
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :role)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':mot_de_passe', $mot_de_passe_hash, PDO::PARAM_STR);
    $query->bindValue(':role', $role, PDO::PARAM_STR);

    try {
        if ($query->execute()) {
            header('Location: admin.php');
            exit;
        } else {
            echo "Erreur lors de l'insertion.";
        }
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
}
?>



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
        }
        .btn:hover {
            background-color: #d2b48c;
        }
        .btn-create {
            display: block;
            width: 200px;
            margin: 0 auto 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5deb3;
        }
        tr:hover {
            background-color: #f0e4d7;
        }
        .actions button {
            margin-right: 5px;
        }
        .role-btn {
            padding: 8px 15px;
            background-color: #8b7765;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 150px; 
            text-align: center;
        }
        .role-btn:hover {
            background-color: #a19080;
        }
        footer {
            margin-top: 40px;s
            text-align: center;
            color: #8b7765;
            font-size: 0.9em;
        }
</style>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="ajouter.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un utilisateur</h1>
        <form action="ajouter.php" method="POST">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div>
                <label for="prenom">Prenom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div>
                <label for="mot_de_passe">mot de passe :</label>
                <input type="text" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="role">Rôle :</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="direction">Direction</option>
                    <option value="client">Client</option>
                    <option value="brasseur">Brasseur</option>
                    <option value="caissier">Caissier</option>
                </select>
            </div>
            <button type="submit" class="btn btn-create">Ajouter</button>
        </form>
        <a href="admin.php" class="btn btn-create">Retour à l'admin</a>
    </div>
    
</body>
</html>
