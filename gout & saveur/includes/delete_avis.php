<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_avis'])) {
    $id_avis = $_POST['id_avis'];
    
    try {
        // Delete the review
        $stmt = $pdo->prepare("DELETE FROM avis WHERE id_avis = ?");
        $stmt->execute([$id_avis]);
        
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
