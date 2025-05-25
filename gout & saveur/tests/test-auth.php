<?php
require_once '../includes/database.php';
session_start();

try {
    // Test de connexion à la base
    $pdo = new PDO("mysql:host=$hostname;dbname=$db_name", $db_user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Création d'un utilisateur test
    $testEmail = "testauth@example.com";
    $testPassword = "Test123!";
    $hashedPassword = password_hash($testPassword, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe) VALUES (?, ?, ?)");
    $stmt->execute(["Test Auth", $testEmail, $hashedPassword]);
    $userId = $pdo->lastInsertId();
    
    // Test de login
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$testEmail]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($testPassword, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_nom'] = $user['nom'];
        echo "Authentification réussie!<br>";
        echo "ID utilisateur: " . $_SESSION['user_id'] . "<br>";
        echo "Nom: " . $_SESSION['user_nom'] . "<br>";
    } else {
        echo "Échec de l'authentification<br>";
    }
    
    // Nettoyage
    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id_user = ?");
    $stmt->execute([$userId]);
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>