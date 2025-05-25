<?php
include 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "INSERT INTO restaurant (nom, localisation, categorie, description, image_url) 
                VALUES (:nom, :localisation, :categorie, :description, :image_url)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $_POST['nom'],
            'localisation' => $_POST['localisation'],
            'categorie' => $_POST['categorie'],
            'description' => $_POST['description'],
            'image_url' => $_POST['image_url']
        ]);

        // Retourner les données en JSON
        echo json_encode([
            'success' => true,
            'data' => [
                'nom' => $_POST['nom'],
                'localisation' => $_POST['localisation'],
                'categorie' => $_POST['categorie'],
                'description' => $_POST['description'],
                'image_url' => $_POST['image_url']
            ]
        ]);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
?>
