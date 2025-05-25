<?php
try {
    // Database connection
    $dsn = "mysql:host=localhost;dbname=your_database;charset=utf8mb4";
    $username = "maram";
    $password = "ekhdemstp777";
    
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get restaurant count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM restaurant");
    $restaurantCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get total reviews
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM avis");
    $reviewCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get total users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM utilisateur");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get average rating
    $stmt = $pdo->query("SELECT AVG(rating) as avg FROM avis");
    $avgRating = number_format($stmt->fetch(PDO::FETCH_ASSOC)['avg'], 1);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
// ... existing code ...