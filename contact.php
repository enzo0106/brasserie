<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - La Nulos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5dc; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
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
        footer {
            margin-top: 40px;
            text-align: center;
            color: #8b7765;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact</h1>
        <form action="traitement_contact.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="btn">Envoyer</button>
            <div class="actions">
            <a href="page_v.html" class="btn">Retour a la page de d'Accueil</a>
            <div>
        </form>
        <footer>
            &copy; 2025 - La RECIDIVISTE - Tous droits réservés
        </footer>
    </div>
</body>
</html>
