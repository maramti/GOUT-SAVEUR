<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_avis = $_POST['id_avis'];
    $contenu = $_POST['contenu'];
    $nbre_etoiles = $_POST['nbre_etoiles'];
    
    try {
        $stmt = $pdo->prepare("UPDATE avis SET contenu = ?, nbre_etoiles = ? WHERE id_avis = ?");
        $stmt->execute([$contenu, $nbre_etoiles, $id_avis]);
        
        header('Location: ../dash.php?success=1');
    } catch(PDOException $e) {
        header('Location: ../dash.php?error=' . urlencode($e->getMessage()));
    }
}
?>
