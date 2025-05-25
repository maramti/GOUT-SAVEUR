<?php
include '../includes/database.php';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    // Validation des données
    if (!empty($name) && !empty($location) && !empty($category) && !empty($image)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO restaurant (nom, localisation, categorie, image_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $location, $category, $image]);
            
            echo "Nouveau restaurant ajouté avec succès.";
            header('Location: dashboard.html');
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion: " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
