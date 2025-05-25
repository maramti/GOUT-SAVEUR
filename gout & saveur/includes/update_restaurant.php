<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $localisation = $_POST['localisation'];
    
    try {
        $stmt = $pdo->prepare("UPDATE restaurant SET nom = ?, categorie = ?, localisation = ? WHERE id_restaurant = ?");
        $stmt->execute([$nom, $categorie, $localisation, $id]);
        
        header('Location: ../dash.php?success=1');
    } catch(PDOException $e) {
        header('Location: ../dash.php?error=1');
    }
}
?>