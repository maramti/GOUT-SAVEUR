<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
</head>
<body s>
    <h3>bienvenue  
        <?php
            if (isset($_SESSION['email']) ){
                $email=$_SESSION['email'] ;

    // Préparer la requête SQL en évitant les injections SQL
                $query = $pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur.email =?");
                $query->execute([$email]);

    // Récupérer et afficher les résultats
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                   echo $row['nom'];
                  
                }
            }    

        ?>
    </h3>
</body>
</html>