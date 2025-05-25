<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    
    try {
        // Vérifier si l'email existe déjà pour un autre utilisateur
        $stmt = $pdo->prepare("SELECT id_user FROM utilisateur WHERE email = ? AND id_user != ?");
        $stmt->execute([$email, $id_user]);
        if ($stmt->rowCount() > 0) {
            header('Location: ../dash.php?error=' . urlencode('Cet email est déjà utilisé par un autre utilisateur'));
            exit;
        }
        
        // Mettre à jour l'utilisateur
        $stmt = $pdo->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, email = ? WHERE id_user = ?");
        $stmt->execute([$nom, $prenom, $email, $id_user]);
        
        header('Location: ../dash.php?success=1');
    } catch(PDOException $e) {
        header('Location: ../dash.php?error=' . urlencode($e->getMessage()));
    }
}
?>
