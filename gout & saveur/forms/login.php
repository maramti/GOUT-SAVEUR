<?php
session_start();
require_once '../includes/database.php';


$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['signin_mail'] ?? '';
    $password = $_POST['signin_password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ? AND mot_de_passe = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();
   

    if ($user) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_nom'] = $user['nom']; // ou prénom selon ta base
        $_SESSION['user_id'] = $user['id_user'];   // utile pour vérification de session

        header("Location: ../homepage.php");
        exit;
    } else {
        $error = "Erreur";
        echo "<p id='erreur'> Veuillez vérifier votre email ou votre mot de passe.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../assets/login.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se Connecter</title>
</head>
<body>
<div class="container">
    <div class="card">
    <div class="front signin" >
        <h3 class="signin_title">Sign In</h3>
    <form method="POST" action="login.php">
        
        <div class="donnees"> 
            <input type="text" name="signin_mail" id="signin_mail" placeholder=" " required>
            <br>
            <label for="signin_mail" id="hidename"> Email </label>
        </div>
        <div class="donnees">
            <input type="password" name="signin_password" id="signin_password" placeholder=" " required>
            <br>
            <label for="signin_passsword" id="hideword"> Mot de passe </label>
        </div>
    
        <div class="partwo">
            <div class="forget">
                <a href="#"> mot de passe oublié?</a>
           
            </div>
            <button type="submit" name="sign">Sign In</button>
            <div>
                <span> <a id="lien" href="#">Je n'ai pas un compte.</a></span>
            </div>
        </div>
    </form>
    </div>
    <div class="back signup" >
        <h3 class="signup_title">Sign Up</h3>
        <form action="signup.php" method="post" style="padding-top:0px;">
            <div class="donnees_signup">
                <input type="text" id="nom" name="nom" placeholder=" ">
                <br>
                <label for="nom">Nom</label>
            </div>
            <div class="donnees_signup">
                <input type="text" id="prenom" name="prenom" placeholder=" " >
                <br>
                <label for="prenom">Prénom</label>
            </div>
            <div class="donnees_signup">
                <input type="email" name="signup_mail" id="signup_mail" placeholder=" " required>
                <br>
                <label for="signup_mail">Email d'utilisateur</label>
            </div>
            <div class="donnees_signup">
                <input type="password" name="signup_password" id="signup_password" placeholder=" " required>
                <br>
                <label for="signup_password">Mot de passe</label>
            </div>
        <!---
            <label for="password">vérifier mot de passe</label>
            <br>
            <input type="password" name="password" id="password" required>
            <br>
            <label for="photo">choisissez une icone</label>
            <br>
            <input type="file" id="photo" name="photo">
            <br>
        --> 
            <div class="donnees_signup">
                <input type="text" id="adresse" name="adresse" placeholder=" ">
                <br>
                <label for="adresse">vous habitez ou?</label>
            </div> 
            <!---
            <label class="remember">
                <input type="checkbox" id="remember">
                <span>Remember me !</span> 
            </label>
            -->
            <br>
            <button type="submit" name="signup">Créer mon compte</button>
            <br><span><a id="lien2">
                J'ai déjà un compte!
            </a>
            </span>
        </form>
        </div>
    </div>
</div>
    <script>
    const cube = document.querySelector('.card');
    document.getElementById('lien').addEventListener('click',ekleb);
    document.getElementById('lien2').addEventListener('click',ekleb);

        function ekleb(){
            cube.classList.toggle('flip');
            /*
            if(document.querySelector('.flip') !== null){
                document.getElementById('hidename').style.display="none";
            }*/
        }
        /*
        function rajaaha(){
            cube.style.transform="rotateY(180deg)";
        }
               
    const parent=document.querySelector('.signin');
    const clique=document.getElementById('lien');
    clique.addEventListener('click',rotation);
        function rotation(){
            parent.classList.toggle('rota');
            setTimeout(ekleb,1000);

        }
            */
    </script>
</body>
</html>