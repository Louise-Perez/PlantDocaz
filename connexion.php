<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
if(isset($_POST['formconnexion'])) {
    $mail_membresconnect = htmlspecialchars($_POST['mail_membresconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($mail_membresconnect) AND !empty($mdpconnect)) {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail_membres = ? AND mdp = ?");
        $requser->execute(array($mail_membresconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo_membres'] = $userinfo['pseudo_membres'];
            $_SESSION['mail_membres'] = $userinfo['mail_membres'];
            $_SESSION['nom_membres'] = $userinfo['nom_membres'];
            $_SESSION['prenom_membres'] = $userinfo['prenom_membres'];
            header("Location: profil.php");
        } 
        else {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    } 
    else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PLANTDOCAZ</title>
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



         <h2>Connexion</h2>
         <section class="encart_connexion">

         <form method="POST" action="">
            <input type="email" name="mail_membresconnect" placeholder="Mail" />
            <input type="password" name="mdpconnect" placeholder="Mot de passe" />
            <br /><br />
            <input type="submit" name="formconnexion" value="Se connecter !" />
         </form>

         <br/> 
         <a href="inscription.php">S'inscrire</a>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </section>

      <?php include 'partie/footer.php'; ?>
   </body>
</html>