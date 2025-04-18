<!DOCTYPE html>
<html>
<head>
<title>RECIDIVISTE - Nos Produits</title>
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

.product-card {
  margin-bottom: 30px;
  transition: transform 0.3s ease;
}
.product-card:hover {
  transform: scale(1.03);
}
.product-image {
  width: 100%;
  height: auto;
}
.badge-new {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #f44336;
  color: white;
  padding: 5px 10px;
  border-radius: 3px;
}
.quantity-selector {
  display: flex;
  align-items: center;
  margin: 15px 0;
}
.quantity-selector button {
  background-color: #333;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}
.quantity-selector input {
  width: 40px;
  text-align: center;
  margin: 0 10px;
  padding: 5px;
}
/* Style pour notification panier */
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: #333;
  color: white;
  padding: 15px;
  border-radius: 5px;
  display: none;
  z-index: 1000;
}
/* Compteur panier */
.cart-counter {
  position: fixed;
  top: 10px;
  right: 10px;
  background-color: #f44336;
  color: white;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 14px;
  z-index: 1000;
}
</style>
</head>
<body class="w3-black">

<?php
// Démarrer la session
session_start();

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Récupérer le nombre d'articles dans le panier
$nombre_articles = 0;
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $item) {
        $nombre_articles += $item['quantite'];
    }
}
?>

<!-- Notification panier -->
<div id="notification" class="notification"></div>

<!-- Compteur panier -->
<?php if ($nombre_articles > 0): ?>
<div class="cart-counter" id="cartCounter"><?php echo $nombre_articles; ?></div>
<?php endif; ?>

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
    <h1 class="w3-jumbo"><span class="w3-hide-small">Découvrez nos</span> Produits</h1>
    <p>Des bières artisanales qui défient les conventions...</p>
  </header>

  <!-- Products Section -->
  <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="products">
    <h2 class="w3-text-light-grey">Notre gamme complète</h2>
    <hr style="width:200px" class="w3-opacity">
    
    <p>Explorez notre sélection de bières artisanales La Récidiviste, chacune brassée avec passion et audace pour offrir une expérience gustative unique. Souvenez-vous que 100% de nos revenus sont reversés pour venir en aide aux sans-abri.</p>

    <p>Chaque gorgée est un pas vers un monde meilleur.</p>

    <!-- Products Grid -->
    <div class="w3-row-padding">
      
      <!-- Product 1: La Nulos -->
      <div class="w3-third product-card">
        <div class="w3-card w3-dark-grey">
          <!--<img src="src/img_biere.png" alt="La Nulos" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>La Nulos</h3>
            <p>Bière blonde - 10.9% alc.</p>
            <p>Goût carton mouillé, avec des notes subtiles de désespoir urbain.</p>
            <div class="quantity-selector"> 
              <button onclick="decrementQuantity('qty1')">-</button>
              <input type="number" id="qty1" value="1" min="1" max="15">
              <button onclick="incrementQuantity('qty1')">+</button>
            </div>
            <p class="w3-large">1.30€</p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(2, 'La Nulos', 1.30, document.getElementById('qty1').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
      <!-- Product 2: La Divinouze -->
      <div class="w3-third product-card">
        <div class="w3-card w3-dark-grey">
          <div class="badge-new">NOUVEAU</div>
          <!--<img src="src/produit2.webp" alt="La Divinouze" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>La Divinouze</h3>
            <p>Bière ambrée - 10.5% alc.</p>
            <p>Goût caniveau, avec une touche d'asphalte et une finale de bitume.</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('qty2')">-</button>
              <input type="number" id="qty2" value="1" min="1" max="15">
              <button onclick="incrementQuantity('qty2')">+</button>
            </div>
            <p class="w3-large">1.50€</p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(3, 'La Divinouze', 1.50, document.getElementById('qty2').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
      <!-- Product 3: L'Expulsion -->
      <div class="w3-third product-card">
        <div class="w3-card w3-dark-grey">
          <!--<img src="src/img_biere2.png" alt="L'Expulsion" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>L'Expulsion</h3>
            <p>Bière brune - 11.2% alc.</p>
            <p>Saveurs de carton défraîchi et d'huissier en colère.</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('qty3')">-</button>
              <input type="number" id="qty3" value="1" min="1" max="15">
              <button onclick="incrementQuantity('qty3')">+</button>
            </div>
            <p class="w3-large">1.80€</p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(4, 'L\'Expulsion', 1.80, document.getElementById('qty3').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
      <!-- Product 4: La Sans-Abri -->
      <div class="w3-third product-card">
        <div class="w3-card w3-dark-grey">
         <!-- <img src="src/img_biere3.png" alt="La Sans-Abri" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>La Sans-Abri</h3>
            <p>Bière blonde spéciale - 11% alc.</p>
            <p>Notes de banc public et de carton de récupération.</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('qty4')">-</button>
              <input type="number" id="qty4" value="1" min="1" max="15">
              <button onclick="incrementQuantity('qty4')">+</button>
            </div>
            <p class="w3-large">1.40€</p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(5, 'La Sans-Abri', 1.40, document.getElementById('qty4').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
      <!-- Product 5: La Comatose -->
      <div class="w3-third product-card">
        <div class="w3-card w3-dark-grey">
          <div class="badge-new">NOUVEAU</div>
          <!--<img src="src/produit5.webp" alt="La Comatose" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>La Comatose</h3>
            <p>Bière triple - 11% alc.</p>
            <p>Puissante et assommante, avec des notes d'urgences médicales.</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('qty5')">-</button>
              <input type="number" id="qty5" value="1" min="1" max="15">
              <button onclick="incrementQuantity('qty5')">+</button>
            </div>
            <p class="w3-large">2.10€</p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(6, 'La Comatose', 2.10, document.getElementById('qty5').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
      <!-- Product 6: La Déchéance -->
      <div class="w3-third product-card">
        <div class="w3-card w3-dark-grey">
          <!--<img src="src/produit6.webp" alt="La Déchéance" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>La Déchéance</h3>
            <p>Bière ambrée vieillie - 12% alc.</p>
            <p>Saveurs complexes de dents manquantes et de mauvaises décisions.</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('qty6')">-</button>
              <input type="number" id="qty6" value="1" min="1" max="15">
              <button onclick="incrementQuantity('qty6')">+</button>
            </div>
            <p class="w3-large">1.90€</p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(7, 'La Déchéance', 1.90, document.getElementById('qty6').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
    </div>
    
    <!-- Pack Promotions -->
    <h2 class="w3-text-light-grey w3-padding-32">Nos packs promo</h2>
    <hr style="width:200px" class="w3-opacity">
    
    <div class="w3-row-padding">
      <!-- Pack 1 -->
      <div class="w3-half product-card">
        <div class="w3-card w3-dark-grey">
          <!--<img src="src/pack6biere.jpg" alt="Pack Découverte" class="product-image"> -->
          <div class="w3-container w3-center">
            <h3>Pack Découverte</h3>
            <p>6 bières assorties pour découvrir toute notre gamme</p>
            <p>3x La Nulos, 2x La Divinouze, 1x L'Expulsion</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('pack1')">-</button>
              <input type="number" id="pack1" value="1" min="1" max="15">
              <button onclick="incrementQuantity('pack1')">+</button>
            </div>
            <p><span class="w3-large">7.50€</span> <span class="w3-opacity w3-text-white"><strike>9.00€</strike></span></p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(8, 'Pack Découverte', 7.50, document.getElementById('pack1').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
      
      <!-- Pack 2 -->
      <div class="w3-half product-card">
        <div class="w3-card w3-dark-grey">
          <!--<img src="src/pack2.webp" alt="Pack Déchéance Totale" class="product-image">-->
          <div class="w3-container w3-center">
            <h3>Pack Déchéance Totale</h3>
            <p>12 bières pour une expérience immersive complète</p>
            <p>Un assortiment qui vous garantit une expérience inoubliable... ou pas.</p>
            <div class="quantity-selector">
              <button onclick="decrementQuantity('pack2')">-</button>
              <input type="number" id="pack2" value="1" min="1" max="15">
              <button onclick="incrementQuantity('pack2')">+</button>
            </div>
            <p><span class="w3-large">15.90€</span> <span class="w3-opacity w3-text-white"><strike>19.80€</strike></span></p>
            <button class="w3-button w3-white w3-margin-bottom" onclick="ajouterAuPanier(9, 'Pack Déchéance Totale', 15.90, document.getElementById('pack2').value)">Ajouter au panier</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Engagement social -->
    <div class="w3-padding-64">
      <h2 class="w3-text-light-grey">Notre engagement</h2>
      <hr style="width:200px" class="w3-opacity">
      <p>Pour chaque bière vendue, 100% des bénéfices sont reversés aux associations d'aide aux sans-abri. Votre achat est un acte solidaire qui contribue directement à offrir un soutien à ceux qui en ont le plus besoin.</p>
      <p>Merci de participer à notre mission tout en dégustant une bière unique qui raconte une histoire... pas toujours glorieuse, mais toujours humaine.</p>
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
function incrementQuantity(id) {
  var input = document.getElementById(id);
  input.value = parseInt(input.value) + 1;
}

function decrementQuantity(id) {
  var input = document.getElementById(id);
  if (parseInt(input.value) > 1) {
    input.value = parseInt(input.value) - 1;
  }
}

function ajouterAuPanier(produitId, produitNom, produitPrix, quantite) {
  // Créer une requête AJAX pour ajouter au panier
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "ajouter_panier.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      // Afficher la notification
      var notification = document.getElementById("notification");
      notification.textContent = quantite + "x " + produitNom + " ajouté au panier !";
      notification.style.display = "block";
      setTimeout(function() {
        notification.style.display = "none";
      }, 3000);

      // Mettre à jour le compteur du panier
      var cartCounter = document.getElementById("cartCounter");
      if (cartCounter) {
        cartCounter.textContent = this.responseText;
      } else {
        // Créer le compteur s'il n'existe pas
        var newCounter = document.createElement("div");
        newCounter.id = "cartCounter";
        newCounter.className = "cart-counter";
        newCounter.textContent = this.responseText;
        document.body.appendChild(newCounter);
      }
    }
  };

  // Envoyer les données
  var data = "produit_id=" + produitId + "&produit_nom=" + encodeURIComponent(produitNom) + "&produit_prix=" + produitPrix + "&quantite=" + quantite;
  xhr.send(data);
}
</script>

</body>
</html>