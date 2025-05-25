<?php
session_start();

include 'includes/database.php' ;
if(isset($_GET['id'])){
    $sql="select * from restaurant where id_restaurant= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_GET['id']]);
    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GOUT & SAVERS</title>
  <link rel="stylesheet" href="assets/restaurant.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="left">
        <img src="/assets/images/logo.png" alt="Logo du restaurant" class="logo">
      </div>
      <div class="center">
        <input type="text" placeholder="Rechercher un plat, un restaurant..." class="search-bar">
      </div>
      <div class="right">
        <nav class="nav-buttons">
          <a href="homepage.php">Accueil</a>
          <a href="about.php">À propos de nous</a>
          <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-icon">
                  <i class="fas fa-user"></i>
                  <div class="dropdown">
                  
                    <a href="forms/logout.php" class="item_user">
                      <i class="fas fa-right-from-bracket"></i> déconnecter
                    </a>
                    <a href="user_interface.php" class="item_user">
                      <i class="fas fa-heart"></i> tableau de bord
                    </a>
                    <a href="settings.html" class="item_user">
                      <i class="fas fa-key"></i>Paramètres
                    </a>
                  </div>
                </div>
              <?php else: ?>
                
                <a href="../forms/login.php" > Se connecter</a>
              <?php endif; ?>
        </nav>
      </div>
    </div>
  </header>
    <div class="name-rating">
    <?php if (isset($restaurant) && $restaurant): ?>
      <h1>Restaurant  <?= $restaurant['nom']?> </h1>
      <p><span class="stars">★★★★★</span></p>
      <?php else: ?> 
        <p> Restaurant introuvable. </p>
      <?php endif; ?>
    </div>
  

  <section class="gallery">
    <div class="image-layout">
      <div class="main-image">
      <?php if (isset($restaurant) && $restaurant): ?>
      <img src="<?= htmlspecialchars($restaurant['image_url']) ?>" alt="<?= htmlspecialchars($restaurant['nom']) ?>" ><br>
      <?php endif; ?>
    </div>
    <!--
      <div class="thumbnails">
        <img src="rc87-dishes-Restaurant-lescargot-2022-10.jpg" alt="plat secondaire" onclick="changeMainImage(this)">
        <img src="r297-Restaurant-lescargot-food-2022-10.jpg" alt="plat secondaire" onclick="changeMainImage(this)">
        <img src="r6c6-Restaurant-lescargot-clam-chowder.jpg" alt="plat secondaire" onclick="changeMainImage(this)">
        <img src="rac5-Restaurant-lescargot-sea-bass (1).jpg" alt="plat secondaire" onclick="changeMainImage(this)">
      </div>
      -->
    </div>
  </section>

  <section class="description">
  <?php if (isset($restaurant) && $restaurant): ?>
  <p><strong>Description : </strong> <?= $restaurant['description']?> </p>
  <?php endif; ?>
  <?php if (isset($_GET['id'])) {
    $id=$_GET['id'];
  }
  ?>
  </section>

  <button>+ Ajoutez votre avis</button>
  <!-- Popup modal for review -->
<div id="popupReview" class="popup-overlay">
  <div class="popup-content">
    <span class="close-btn" id="closePopup">&times;</span>
    <h3>Laisser un avis</h3>
    <form id="formAvis" method="post" action="includes/envoi-avis.php">
      <label for ="note">Note :</label><br>
      <div class="stars" id="starRating">
        <span data-value="1">★</span>
        <span data-value="2">★</span>
        <span data-value="3">★</span>
        <span data-value="4">★</span>
        <span data-value="5">★</span>
      </div>
      <input type="hidden" id="note" name="nbre" required><br><br>
      <input type="hidden" name="id_restaurant" value="<?php echo $_GET['id']?>">
      <input type="hidden" name="id_utilisateur" value="<?php echo $_SESSION['user_id'] ?>">

      <label for="commentaire" >Commentaire :</label><br>
      <textarea id="commentaire" rows="4" name="avis"></textarea><br><br>

      <button type="submit" name="envoyer-avis">Envoyer l’avis</button>
    </form>
  </div>
</div>


  <section class="reviews">
    <h2>Avis des visiteurs</h2>
    <?php
    if (isset($_GET['id'])) {
        $id_restaurant = $_GET['id'];
        $sql_avis = "SELECT a.*, u.nom, u.prenom 
                    FROM avis a
                    JOIN utilisateur u ON a.id_user = u.id_user
                    WHERE a.id_restaurant = :id_restaurant
                    ORDER BY a.id_avis DESC";
        $stmt_avis = $pdo->prepare($sql_avis);
        $stmt_avis->execute(['id_restaurant' => $id_restaurant]);
        $avis = $stmt_avis->fetchAll(PDO::FETCH_ASSOC);

        foreach ($avis as $review) {
            $stars = str_repeat('★', $review['nbre_etoiles']);
            echo '<div class="review">';
            echo '<h3>' . htmlspecialchars($review['prenom'] . ' ' . htmlspecialchars($review['nom'])) . '</h3>';
            echo '<p>' . $stars . '</p>';
            echo '<p>' . htmlspecialchars($review['contenu']) . '</p>';
            echo '</div>';
        }
    }
    ?>
  </section>


  <script>
 
  document.querySelectorAll('#starRating span').forEach(function(star) {
    star.addEventListener('click', function() {
      var value = this.getAttribute('data-value');
      document.getElementById('note').value = value;
    });
  });

    
    function changeMainImage(thumbnail) {
      const main = document.getElementById("mainImage");
      const tempSrc = main.src;
      main.src = thumbnail.src;
      thumbnail.src = tempSrc;
    }
    
    const btnAjouterAvis = document.querySelector('button');
const popup = document.getElementById('popupReview');
const closeBtn = document.getElementById('closePopup');
const form = document.getElementById('formAvis');
const noteInput = document.getElementById('note');
const stars = document.querySelectorAll('#starRating span');

  <?php if (isset($_SESSION['user_id'])): ?>
    btnAjouterAvis.addEventListener('click', () => {
      popup.style.display = 'flex';
    });
  <?php else: ?>
    btnAjouterAvis.addEventListener('click', () => {
      alert("Vous devez être connecté pour laisser un avis.");
    });
  <?php endif; ?>


closeBtn.addEventListener('click', () => {
  popup.style.display = 'none';
});
/*
form.addEventListener('submit', (e) => {
  e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire

  const nom = document.getElementById('nom').value;
  const note = noteInput.value;
  const commentaire = document.getElementById('commentaire').value;
  const idRestaurant = document.querySelector('input[name="id_restaurant"]').value;
  const idUtilisateur = document.querySelector('input[name="id_utilisateur"]').value;

  // Préparer les données à envoyer
  const formData = new FormData();
  formData.append('nbre', note);
  formData.append('avis', commentaire);
  formData.append('id_restaurant', idRestaurant);
  formData.append('id_utilisateur', idUtilisateur);

  // Utiliser fetch pour envoyer les données
  fetch('includes/envoi-avis.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    // Afficher le nouvel avis dans la page
    const nouvelAvis = document.createElement('div');
    nouvelAvis.className = 'review';
    nouvelAvis.innerHTML = `
      <h3>${nom}</h3>
      <p>${'⭐'.repeat(note)}</p>
      <p>${commentaire}</p>
    `;
    document.querySelector('.reviews').appendChild(nouvelAvis);
    
    // Réinitialiser le formulaire et les étoiles
    form.reset();
    stars.forEach(s => s.classList.remove('selected'));
  })
  .catch(error => console.error('Error:', error));
});*/

  // Gérer le clic sur les étoiles
/*const stars = document.querySelectorAll('#starRating span');
const noteInput = document.getElementById('note');*/

stars.forEach(star => {
  star.addEventListener('click', () => {
    const rating = parseInt(star.getAttribute('data-value'));
    noteInput.value = rating;
    stars.forEach(s => {
      s.classList.toggle('selected', parseInt(s.getAttribute('data-value')) <= rating);
    });
  });

  star.addEventListener('mouseenter', () => {
    const rating = parseInt(star.getAttribute('data-value'));
    stars.forEach(s => {
      s.classList.toggle('hovered', parseInt(s.getAttribute('data-value')) <= rating);
    });
  });

  star.addEventListener('mouseleave', () => {
    stars.forEach(s => s.classList.remove('hovered'));
  });
});


</script>

</body>
</html>
