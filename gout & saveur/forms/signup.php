
<?php
session_start();
include '../includes/database.php';

if (!$pdo) {
    die("connection échouée avec signup.php.");
}

if (isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom']; 
    $email = $_POST['signup_mail'];
    $mot_de_passe = password_hash($_POST['signup_password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $mot_de_passe]);

    // Récupérer l'ID de l'utilisateur créé
    $user_id = $pdo->lastInsertId();
       
    if ($stmt){
        $_SESSION['user_id'] = $user_id; 
        $_SESSION['user_nom'] = $nom;
        header("Location: ../homepage.php");
        exit(); 
    } else {
        echo "Erreur lors de l'insertion des données.";
    }
}
?>