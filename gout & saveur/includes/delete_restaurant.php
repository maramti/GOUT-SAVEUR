<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_restaurant'])) {
    $id_restaurant = $_POST['id_restaurant'];
    
    try {
        // Supprimer d'abord les avis associés au restaurant
        $stmt = $pdo->prepare("DELETE FROM avis WHERE id_restaurant = ?");
        $stmt->execute([$id_restaurant]);
        
        // Ensuite supprimer le restaurant
        $stmt = $pdo->prepare("DELETE FROM restaurant WHERE id_restaurant = ?");
        $stmt->execute([$id_restaurant]);
        
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>