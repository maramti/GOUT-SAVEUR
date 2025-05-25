<?php
// Connexion à la base de données avec PDO
$host = 'localhost';
$dbname = 'db_pfa'; // Mets ici le nom de ta base
$user = 'maram'; // Ton utilisateur MySQL
$pass = 'ekhdemstp777'; // Ton mot de passe, si tu en as un

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Active les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les produits
    $stmt = $pdo->query("SELECT * FROM restaurant");
    $restos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gout & Saveurs</title>
    <style>
        .resto {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            transition: 0.4s ease-in ;
            
        }
        img {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
        }
        .resto:hover{
            scale: 1.1;
            box-shadow: 1px 1px 10px grey;
        }
    </style>
</head>
<body>

<h1>Des Restaurants</h1>
<div>
    <?php if ($restos): ?>
        <?php foreach ($restos as $resto): ?>
            <div class="resto">
                <h3><?= htmlspecialchars($resto['nom']) ?></h3>
                <img src="<?= htmlspecialchars($resto['image_url']) ?>" alt="<?= htmlspecialchars($resto['nom']) ?>">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun restaurant/café trouvé.</p>
    <?php endif; ?>
</div>

</body>
</html>
