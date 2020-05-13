<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLANTDOCAZ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="image/icone.png" />
</head>
<body>

<header class="navbar">
         <ul>
            <li class="navLogo"><a href="index.php"><img src="image/icone.png"></a></li>
            <li><a href="index.php">Accueil</a></li>             
            <li><a href="rechercher.php">Rechercher</a></li>
            <li><a href="deposerAnnonce.php">Déposer une annonce</a></li>
             <!-- <li><a href="messagerie.html">Messages</a></li> -->
            <li><a href="profil.php">            <?php  
               if ($_SESSION){
                  echo $_SESSION['prenom_membres'] . ' ' . $_SESSION['nom_membres']; 
               } 
               else {
                   echo 'Se connecter';
               }?>
            </a></li>
            <li><a href="deconnexion.php">   <?php  
               if ($_SESSION){
                  echo 'Se déconnecter'; 
               } 
               else {
                   echo '';
               }?></a></li>
         </ul>
     </header>

    <section id="headband">
      <img src="image/bg.png">
      <p> Plantdocaz est un site basé sur le partage et l'échange de plantes. Vous pouvez déposer une annonce si vous souhaitez
          vous séparer d'une plante, donner des semences, mais également contacter par mail des membres s'ils ont déposé une annonce qui vous plaît.</p>
    </section>

    <section class="espace_inscription_connexion"> 
      <button><a href="inscription.php">Inscription</a></button> 
      <button><a href="connexion.php">Se connecter</a></button>
    </section>



    <?php include 'partie/footer.php'; ?>

</body>
</html>