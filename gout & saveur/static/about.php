<?php
session_start();
include 'includes/database.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOUT & SAVEURS - À propos</title>
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <link href="assets/homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>
  
  <body>
  
    <!-- Header & Navigation -->
    <header>
      <div class="container">
        <div class="logo">
          <a href="#">
            <span class="logo-icon"><img src="assets/images/logo.png" style="width:40px;"></span>
            <span class="logo-text">GOUT & SAVEURS</span>
          </a>
        </div>
  
        <div class="mobile-menu-toggle">
          <i class="fas fa-bars"></i>
        </div>

  
        <nav class="main-nav">
          <ul>
            <li><a href="homepage.php">Accueil</a></li>
            <li><a href="about.php" class="active" style="color:black;">À propos de nous</a></li>
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
              </li></li>
            </li>
          </ul>
        </nav>
      </div>
    </header>
  
    <!-- About Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>À propos de nous</h1>
        <p>Connecter les passionnés de gastronomie à des expériences culinaires exceptionnelles.</p>
      </div>
    </section>
  
    <section class="search-section" style="padding: 60px 20px;">
      <div class="container">
        <div class="about-content" style="text-align: center; max-width: 800px; margin: auto;">
          <div style="display: flex; align-items: center; gap: 30px; flex-wrap: wrap; justify-content: center;">
  <!-- Texte à gauche -->
  <div style="flex: 1; min-width: 280px; text-align: justify;">
  <h2 style="text-align: left;">Notre Histoire</h2>
  <p>
    GOUT & SAVEURS est une plateforme innovante dédiée à la découverte des meilleurs restaurants, cafés et lieux gastronomiques près de chez vous. 
    Créée par des passionnés de cuisine et de technologie, elle vise à rapprocher les amateurs de bonne chère des établissements qui méritent d’être connus.
  </p>
</div>


  <!-- Image à droite -->
  <div style="flex: 1; min-width: 280px; text-align: center;">
    <img src="assets/images/about-history.jpg" alt="Notre Histoire" style="max-width: 100%; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  </div>
</div>

<h2 style="margin-top: 90px; text-align: center;">Notre Objectif</h2>
<p style="text-align: center; max-width: 700px; margin: auto;">
  Mettre en relation les passionnés de gastronomie avec des expériences culinaires exceptionnelles 
  et bâtir une communauté où les avis sincères guident chacun vers les meilleures adresses.
</p>

<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 40px;">
  <!-- Carte 1 -->
  <div style="background: white; padding: 30px; border-radius: 12px; width: 280px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center;">
    <div style="background-color:rgb(245, 210, 165); width: 60px; height: 60px; margin: 0 auto 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
      <i class="fas fa-map-marker-alt" style="font-size: 24px; color: rgb(250, 147, 12);"></i>
    </div>
    <h3 style="margin-bottom: 10px;">Découvrir</h3>
    <p style="font-size: 15px;">Trouvez les meilleurs restaurants, cafés et lieux près de chez vous, filtrés par type de cuisine, prix et plus.</p>
  </div>

  <!-- Carte 2 -->
  <div style="background: white; padding: 30px; border-radius: 12px; width: 280px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center;">
    <div style="background-color: rgb(245, 210, 165); width: 60px; height: 60px; margin: 0 auto 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
      <i class="fas fa-star" style="font-size: 24px; color:rgb(250, 147, 12);"></i>
    </div>
    <h3 style="margin-bottom: 10px;">Noter & Évaluer</h3>
    <p style="font-size: 15px;">Partagez vos expériences et aidez les autres à faire des choix éclairés pour leurs repas.</p>
  </div>


        </div>
      </div>
    </section>
  
  </body>
  </html>
