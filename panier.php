<?php
// Démarrer la session
session_start();

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Calculer le total du panier
$total_panier = 0;
foreach ($_SESSION['panier'] as $item) {
    $total_panier += $item['prix'] * $item['quantite'];
}

// Traiter la validation de la commande
if (isset($_POST['valider_commande']) && !empty($_SESSION['panier'])) {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        $message_erreur = "Vous devez vous connecter pour finaliser votre commande.";
    } else {
        // Connexion à la base de données
        $host = "sql211.infinityfree.com";
        $db_name = "if0_38342553_db_bts";
        $username = "if0_38342553";     
        $password = "K8d7yr5JtUF"; 
        
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Insérer la commande dans la base de données
            $stmt = $conn->prepare("INSERT INTO commandes (client_id, total, statut) VALUES (:client_id, :total, 'en attente')");
            $stmt->bindParam(':client_id', $_SESSION['user_id']);
            $stmt->bindParam(':total', $total_panier);
            $stmt->execute();

            $commande_id = $conn->lastInsertId();

            foreach ($_SESSION['panier'] as $item) {
                $stmt = $conn->prepare("INSERT INTO commande_produits (commande_id, produit_id, quantite) VALUES (:commande_id, :produit_id, :quantite)");
                $stmt->bindParam(':commande_id', $commande_id);
                $stmt->bindParam(':produit_id', $item['id']);
                $stmt->bindParam(':quantite', $item['quantite']);
                $stmt->execute();
            }
            
            // Vider le panier
            $_SESSION['panier'] = [];
            
            $message_succes = "Votre commande a été validée avec succès!";
        } catch(PDOException $e) {
            $message_erreur = "Erreur: " . $e->getMessage();
        }
    }
}

// Traiter la suppression d'un article
if (isset($_GET['supprimer'])) {
    $index = (int)$_GET['supprimer'];
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer le tableau
        
        // Rediriger pour éviter les soumissions multiples
        header("Location: panier.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>RECIDIVISTE - Votre Panier</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}

.cart-table {
  width: 100%;
  border-collapse: collapse;
}
.cart-table th, .cart-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #555;
}
.cart-table th {
  background-color: #333;
}
.quantity-cell {
  display: flex;
  align-items: center;
}
.quantity-cell button {
  background-color: #333;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  margin: 0 5px;
}
.quantity-cell input {
  width: 40px;
  text-align: center;
  padding: 5px;
}
.alert {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
}
.alert-success {
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}
.alert-danger {
  color: #a94442;
  background-color: #f2dede;
  border-color: #ebccd1;
}
</style>
</head>
<body class="w3-black">

<!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="src/brasserie_logo.png" style="width:100%">
  <a href="page_v.html" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>Accueil</p>
  </a>
  <a href="produit.php" class="w3-bar-item w3-button w3-padding-large w3-black">
    <i class="fa fa-beer w3-xxlarge"></i>
    <p>Produits</p>
  </a>
  <a href="contact.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-envelope w3-xxlarge"></i>
    <p>Contact</p>
  </a>
  <a href="panier.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-shopping-cart w3-xxlarge"></i>
    <p>Panier</p>
  </a>
  <a href="index.html" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class=""></i>
    <p>lobby</p>
  </a>
</nav>
 

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="index.html" class="w3-bar-item w3-button" style="width:20% !important">ACCUEIL</a>
    <a href="index.html#about" class="w3-bar-item w3-button" style="width:20% !important">À PROPOS</a>
    <a href="produit.php" class="w3-bar-item w3-button" style="width:20% !important">PRODUITS</a>
    <a href="index.html#photos" class="w3-bar-item w3-button" style="width:20% !important">PHOTOS</a>
    <a href="panier.php" class="w3-bar-item w3-button" style="width:20% !important">PANIER</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
  <!-- Header/Home -->
  <header class="w3-container w3-padding-32 w3-center w3-black" id="home">
    <h1 class="w3-jumbo"><span class="w3-hide-small">Votre</span> Panier</h1>
    <p>Finalisez votre commande et profitez de nos bières artisanales</p>
  </header>

  <!-- Cart Section -->
  <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="cart">
    <h2 class="w3-text-light-grey">Articles dans votre panier</h2>
    <hr style="width:200px" class="w3-opacity">
    
    <?php if (isset($message_succes)): ?>
    <div class="alert alert-success">
      <?php echo $message_succes; ?>
    </div>
    <?php endif; ?>
    
    <?php if (isset($message_erreur)): ?>
    <div class="alert alert-danger">
      <?php echo $message_erreur; ?>
    </div>
    <?php endif; ?>
    
    <?php if (empty($_SESSION['panier'])): ?>
      <p>Votre panier est vide. <a href="produit.php" class="w3-text-white">Continuez vos achats</a>.</p>
    <?php else: ?>
      <table class="cart-table w3-text-white">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($_SESSION['panier'] as $index => $item): ?>
            <tr>
              <td><?php echo htmlspecialchars($item['nom']); ?></td>
              <td><?php echo number_format($item['prix'], 2); ?>€</td>
              <td>
                <div class="quantity-cell">
                  <button onclick="updateQuantity(<?php echo $index; ?>, <?php echo $item['quantite'] - 1; ?>)">-</button>
                  <input type="number" id="qty<?php echo $index; ?>" value="<?php echo $item['quantite']; ?>" min="1" max="15" onchange="updateQuantity(<?php echo $index; ?>, this.value)">
                  <button onclick="updateQuantity(<?php echo $index; ?>, <?php echo $item['quantite'] + 1; ?>)">+</button>
                </div>
              </td>
              <td><?php echo number_format($item['prix'] * $item['quantite'], 2); ?>€</td>
              <td><a href="panier.php?supprimer=<?php echo $index; ?>" class="w3-text-red">Supprimer</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="w3-right-align"><strong>Total:</strong></td>
            <td><strong><?php echo number_format($total_panier, 2); ?>€</strong></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
      
      <div class="w3-padding-32">
        <form method="post" action="panier.php">
          <button type="submit" name="valider_commande" class="w3-button w3-white w3-margin-bottom">Valider ma commande</button>
          <a href="produit.php" class="w3-button w3-grey w3-margin-bottom">Continuer mes achats</a>
        </form>
      </div>
    <?php endif; ?>
    
    <!-- Information de paiement et livraison -->
    <div class="w3-padding-32">
      <h2 class="w3-text-light-grey">Informations importantes</h2>
      <hr style="width:200px" class="w3-opacity">
      <p>Le paiement s'effectue s'effectue une fois que le caissier a valider la commande.</p>
      <p>Les commandes sont généralement prêtes sous 24 à 48 heures.</p>
      <p>100% des bénéfices sont reversés aux associations d'aide aux sans-abri.</p>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-content w3-padding-64 w3-text-grey w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
    
  <!-- End footer -->
  </footer>

<!-- END PAGE CONTENT -->
</div>

<script>
function updateQuantity(index, newQuantity) {
  if (newQuantity < 1) {
    newQuantity = 1;
  }
  
  // Créer une requête AJAX pour mettre à jour la quantité
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "update_panier.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      // Recharger la page pour mettre à jour les totaux
      window.location.reload();
    }
  };
  
  // Envoyer les données
  var data = "index=" + index + "&quantite=" + newQuantity;
  xhr.send(data);
}
</script>

</body>
</html>