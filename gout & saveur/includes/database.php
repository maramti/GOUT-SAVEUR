<?php
$hostname = "localhost";
$db_user = "maram";
$password = "ekhdemstp777";
$db_name = "db_pfa";

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$hostname;dbname=$db_name", $db_user, $password);
    
    // Définir le mode d'erreur pour générer des exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  
} catch (PDOException $e) {
    echo "Connection échouée avec database.php: " . $e->getMessage();
}
?>
