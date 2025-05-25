<?php
session_start();
include 'database.php';



if (isset($_POST['envoyer-avis'])) {
    $nombre = $_POST['nbre'];
    $avis = $_POST['avis']; 
    $id_user=$_POST['id_utilisateur'];
    $id_resto=$_POST['id_restaurant'];
    $insertQuery = "INSERT INTO avis (contenu, id_user, nbre_etoiles,id_restaurant) VALUES ('$avis', '$id_user', '$nombre','$id_resto')";     
}
try {
    // Exécution de la requête sans protection contre les injections SQL
    $success = $pdo->exec($insertQuery);

    if ($success) {
        echo $insertQuery ;
        header("location: ../restaurant.php?id=" .$id_resto);
     
    } else {
        echo "Erreur lors de l'ajout de l'avis.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

