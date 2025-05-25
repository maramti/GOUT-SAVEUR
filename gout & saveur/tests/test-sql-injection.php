<?php
require_once '../includes/database.php';


    $pdo = new PDO("mysql:host=$hostname;dbname=$db_name", $db_user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test 1: Injection SQL basique
    $maliciousInput = "test' OR '1'='1";
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$maliciousInput]);
    
    if ($stmt->rowCount() > 0) {
        echo "ÉCHEC: Injection SQL possible avec: $maliciousInput<br>";
    } else {
        echo "SUCCÈS: Protection contre l'injection basique<br>";
    }

?>
<!--
    // Test 2: Injection avec commentaire
    $maliciousInput2 = "admin'--";
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ? AND mot_de_passe = 'any'");
    $stmt->execute([$maliciousInput2]);
    
    if ($stmt->rowCount() > 0) {
        echo "ÉCHEC: Injection avec commentaire possible<br>";
    } else {
        echo "SUCCÈS: Protection contre les injections avec commentaires<br>";
    }

    // Test 3: Injection UNION
    $maliciousInput3 = "' UNION SELECT * FROM utilisateur--";
    try {
        $stmt = $pdo->prepare("SELECT nom FROM utilisateur WHERE email = ?");
        $stmt->execute([$maliciousInput3]);
        echo "ÉCHEC: Injection UNION possible<br>";
    } catch (PDOException $e) {
        echo "SUCCÈS: Protection contre les injections UNION<br>";
    }

} catch(PDOException $e) {
    echo "Erreur lors du test: " . htmlspecialchars($e->getMessage());
}
?>
-->