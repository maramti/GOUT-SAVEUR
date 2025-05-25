<?php
session_start();
include 'includes/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GOUT & SAVEURS</title>
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
 <link href="assets/homepage.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
</style>
</head>

<body>

  <!-- Header & Navigation -->
  <header>
    <div class="container">
      <div class="logo">
        <a href="#">
          <span class="logo-icon"><img src="assets/images/logo.png" style="width:40px;"></i></span>
          <span class="logo-text">GOUT & SAVEURS</span>
        </a>
      </div>
      
      <div class="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
      </div>
      <?php if (isset($_SESSION['user_id'])): ?>
      <div >
        <h3 class="welcome message">Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> !</h3>
      </div>
    <?php endif; ?>
      <nav class="main-nav">
        <ul>
          <li><a href="homepage.php" class="active" style="color:black;">Acceuil</a></li>
          <li><a href="about.php">A propos de nous</a></li>
          <li>
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
                <a href="forms/login.php" class="btn btn-outline" >Se connecter</a></li>
            <?php endif; ?>
              </li>
        </ul>
      </nav>
    </div>
  </header>
  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Gout & Saveurs</h1>
      <p>Découvrir les bons plans</p>
      <a href="#search" class="btn btn-primary btn-large">rechercher un restaurant/café</a>
    </div>
  </section>

  <!-- Main Search Section -->
  <section id="search" class="search-section">
    <div class="container">
      <div class="search-container">
        <div class="search-box">
            <form method="POST" action="homepage.php">
            <i class="fas fa-search"></i>
            <input type="text" id="resultInput" name="query" placeholder="taper un nom de restaurant/café">
            <button type="submit" style="display: none;"></button>
        </div>
        <?php 
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['query'])) {
  $query = $_POST['query'];
  // Stocke les résultats en session
  $_SESSION['search_result'] = shell_exec("python includes/indexer.py " . escapeshellarg($query));
  $_SESSION['search_query'] = $query;
  // Redirige en GET pour éviter la répétition au refresh
  header("Location: homepage.php?show_results=1");
  exit();
}

// Affichage des résultats si demandé en GET
if (isset($_GET['show_results']) && isset($_SESSION['search_result'])) {
  echo "<h3 id='title'>Résultats de la recherche :</h3>";
  echo "<pre>" . $_SESSION['search_result'] . "</pre>";

  // Optionnel : nettoie la session après affichage
  unset($_SESSION['search_result']);
  unset($_SESSION['search_query']);
}
?>  
 </div>
       </div>
    </div>
    </section>
<script> document.querySelector('a[href="#search"]').addEventListener('click', function(e) {
  e.preventDefault();
  const target = document.querySelector(this.getAttribute('href'));
  const headerHeight = document.querySelector('header').offsetHeight;
  const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
  
  window.scrollTo({
    top: targetPosition,
    behavior: 'smooth'
  });
});

window.addEventListener('scroll', function() {
  const searchSection = document.querySelector('#search');
  const sectionPosition = searchSection.getBoundingClientRect().top;
  const screenPosition = window.innerHeight / 1.3;
  
  if(sectionPosition < screenPosition) {
    searchSection.classList.add('visible');
  }
});
</script>
</body>
</html>