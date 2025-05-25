<?php
include 'database.php';

if(isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];
    
    try {
        // Supprimer d'abord les avis de l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM avis WHERE id_user = ?");
        $stmt->execute([$id_user]);
        
        // Ensuite supprimer l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id_user = ?");
        $stmt->execute([$id_user]);
        
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>