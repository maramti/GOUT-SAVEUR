<?php

include 'includes/database.php' ;
if(isset($_GET['id'])){
    $sql="select * from restaurant where id= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_GET['id']]);
    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src='js/avis.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="assets/interface-resto.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gout & Saveurs</title>
</head>
<body>
<?php include 'static/header.php'; ?>
    <div class="">
    <?php if (isset($restaurant) && $restaurant): ?>
        
        
        <div class="bloc1">
        <img src="<?= htmlspecialchars($restaurant['image_url']) ?>" alt="<?= htmlspecialchars($restaurant['nom']) ?>" ><br>
        <a><i class="fas fa-pencil"></i>ajouter un commentaire</a>
        
        </div>
        <div class="bloc2">
        <h1 id="nom"> <strong> <?= $restaurant['nom']?> </strong></h1>
        <p><strong>Catégorie : </strong> <?= $restaurant['categorie']?> </p>
        <p><strong>Description : </strong> <?= $restaurant['description']?> </p>
    </div>
 
    <?php else: ?> 
        <p> Restaurant introuvable. </p>
    
    </div> 
     <?php endif; ?>
     <div class="bloc-filtrage">
        <h3>tableau de filtrage</h3>
     </div>
    
 
</body>
</html>