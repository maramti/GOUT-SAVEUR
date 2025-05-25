<?php
session_start();
include 'includes/database.php';

// Check if the form was submitted (POST request)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // For debugging
    // echo "Email: " . $email . "<br>";
    // echo "Password: " . $password . "<br>";

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ? AND mot_de_passe = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_nom'] = $user['nom']; // ou prénom selon ta base
        $_SESSION['user_id'] = $user['id'];   // utile pour vérification de session

        header("Location: dash.php");
        exit;
    } else {
        $error = "Erreur";
        echo "<p id='erreur'> Veuillez vérifier votre email ou votre mot de passe.</p>";
    }
}
?>