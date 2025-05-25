<?php
session_start();
include 'includes/database.php' ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/projet.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body style="background-color:#f0f0f0; background-image:none;">
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="welcome-message">
        <h1 style="color:black;">Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> !</h1>
      </div>
    <?php endif; ?>
    <nav class="navbar" >
        <ul >
          <li><a href="../main.php" style="color:black;">Acceuil</a></li>
          <li style="color:black;"><a href="#" style="color:black;">A propos de nous</a></li>
          <li >
              <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-icon">
                  <i class="fas fa-user" style="color:black;"></i>
                  <div class="dropdown">
                  
                    <a href="forms/logout.php" class="item_user">
                      <i class="fas fa-right-from-bracket" style="color:black;" ></i> se déconnecter
                    </a>
                    <a href="user_interface.php" class="item_user">
                      <i class="fas fa-heart" style="color:black;"></i> tableau de bord
                    </a>
                    <a href="settings.html" class="item_user">
                      <i class="fas fa-key" style="color:black;"></i>Paramètres
                    </a>
                  </div>
                </div>
              <?php else: ?>
                
                <a href="forms/login.php" style="color:black;" > Se connecter</a>
              <?php endif; ?>
          </li>
        </ul>
      </nav>
</body>
</html>