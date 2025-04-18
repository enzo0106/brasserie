<?php
session_start();
require 'config_admin.php';
require_once 'auth_check.php'; 


checkUserRole(['admin']);



function writeLog($action) {
    try {
        $date = date('Y-m-d H:i:s');
        $user = isset($_SESSION['email']) ? $_SESSION['email'] : 'Utilisateur inconnu';
        $ip = $_SERVER['REMOTE_ADDR'];
        $logMessage = "[$date] - IP: $ip - Utilisateur: $user - Action: $action\n";
        
        // Utilise le chemin absolu pour être sûr
        $logFile = __DIR__ . '/logs.tkt';
        
        // Vérifie si on peut écrire dans le fichier
        if (file_put_contents($logFile, $logMessage, FILE_APPEND) === false) {
            error_log("Impossible d'écrire dans le fichier de logs: $logFile");
        }
    } catch (Exception $e) {
        error_log("Erreur lors de l'écriture des logs: " . $e->getMessage());
    }
}


if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    
    // Récupérer les informations de l'utilisateur avant suppression
    $stmtUser = $pdo->prepare("SELECT email FROM utilisateurs WHERE id = ?");
    $stmtUser->execute([$id]);
    $userInfo = $stmtUser->fetch();
    
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
    
    // Écrire dans le fichier de logs AVANT la redirection
    writeLog("Suppression de l'utilisateur ID:$id (Email: " . ($userInfo['email'] ?? 'inconnu') . ")");
    
    header("Location: admin.php");
    exit;
}

if (isset($_GET['update_user']) && isset($_GET['new_role'])) {
    $id = $_GET['update_user'];
    $newRole = $_GET['new_role'];
    
    // Récupérer l'ancien rôle avant mise à jour
    $stmtOldRole = $pdo->prepare("SELECT role, email FROM utilisateurs WHERE id = ?");
    $stmtOldRole->execute([$id]);
    $userInfo = $stmtOldRole->fetch();
    $oldRole = $userInfo['role'] ?? 'inconnu';
    
    $stmt = $pdo->prepare("UPDATE utilisateurs SET role = ? WHERE id = ?");
    $stmt->execute([$newRole, $id]);
    
    // Écrire dans le fichier de logs AVANT la redirection
    writeLog("Changement de rôle pour l'utilisateur ID:$id (Email: " . ($userInfo['email'] ?? 'inconnu') . ") - Ancien rôle: $oldRole - Nouveau rôle: $newRole");
    
    header("Location: admin.php");
    exit;
}

//Récupération des utilisateurs
$sql = "SELECT * FROM utilisateurs";
$result = $pdo->query($sql);
$utilisateurs = $result->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau d'administration</title>
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
            margin-top: 40px;
            text-align: center;
            color: #8b7765;
            font-size: 0.9em;
        }
    </style>
    <script>
function changeRole(button, userId) {
    const roles = ['client', 'brasseur', 'Caissier', 'admin'];
    let currentRole = button.innerText;
    let nextRoleIndex = (roles.indexOf(currentRole) + 1) % roles.length;
    let newRole = roles[nextRoleIndex];

    button.innerText = newRole;

    // Envoyer la mise à jour du rôle au serveur
    fetch(`admin.php?update_user=${userId}&new_role=${newRole}`)
        .then(response => response.text())
        .then(data => {
            console.log("Réponse du serveur :", data);
        })
        .catch(error => {
            console.error("Erreur lors de la mise à jour du rôle :", error);
        });
}
</script>


</head>
<body>
    <div class="container">
        <h1>Panneau d'administration</h1>
        <a href="ajouter.php" class="btn btn-create">ajouter utilisateurs</a>
        <a href="view_logs.php" class="btn btn-create">Voir les logs</a>
        <table>
            <thead>
                <tr>
                    <th> id</th>
                    <th> Nom</th>
                    <th> Prenom</th>
                    <th> Email</th>
                    <th> Role</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($utilisateurs as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['nom']) ?></td>
        <td><?= htmlspecialchars($user['prenom']) ?></td> 
        <td><?= htmlspecialchars($user['email']) ?></td>
        
        <td>
         

        <button class="role-btn" onclick="changeRole(this, <?= $user['id'] ?>)">
                <?= htmlspecialchars($user['role']) ?>
            </button>


        </td>
        <td class="actions">   
            <a href="admin.php?delete_user=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
        </table>
    </div>
</body>
</html>
        
