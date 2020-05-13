<?php
session_start();

   $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
   if(isset($_POST['formannonce'])) {
      $nom_plante = htmlspecialchars($_POST['nom_plante']);
      $description_annonce = htmlspecialchars($_POST['description_annonce']);
      $ville_annonce = htmlspecialchars($_POST['ville_annonce']);
      if(!empty($_SESSION)) {
         if(!empty($_POST['nom_plante']) AND !empty($_POST['description_annonce']) AND !empty($_POST['ville_annonce'])) {
            $nom_plantelength = strlen($nom_plante);
               if($nom_plantelength <= 255) {     
                  $insertmbr = $bdd->prepare("INSERT INTO annonces(nom_plante, description_annonce, ville_annonce, date_ajout, annonce_active, id_membres) VALUES(?, ?, ?, NOW(), 1,'".$_SESSION['id']."')");
                  $insertmbr->execute(array($nom_plante, $description_annonce, $ville_annonce));
               } 
               else {
                  $erreur = "Votre Titre ne doit pas dépasser 255 caractères !";
               }
         } 
         else {
            $erreur = "Tous les champs doivent être complétés !";
         }
      }
      else {
         $erreur = "Vous devez être connecté pour publier une annonce";
      }
   }
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer annonce - PLANTDOCAZ</title>
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

      <section class="depot_annonce">
         <h2>Publier une annonce</h2>
         
         <?php
            if(isset($erreur)) {
               echo '<font color="red">'.$erreur."</font>";
            }
         ?>

         <form method="POST" action="">
            <table>
               <tr><!-- Nom --> 
                  <td align="right">
                     <label for="nom_plante">Nom : </label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre Nom" id="nom_plante" name="nom_plante"/>
                  </td>
               </tr>
               <tr><!-- Description --> 
                  <td align="right">
                     <label for="description_annonce">Description: </label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre Description" id="description_annonce" name="description_annonce"/>
                  </td>
               </tr>
               <tr><!-- Ville--> 
                  <td align="right">
                     <label for="ville_annonce">Ville :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre ville" id="ville_annonce" name="ville_annonce"/>
                  </td>
               </tr>            
               <tr><!-- Submit--> 
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="formannonce" value="Je valide mon annonce"/>
                  </td>
               </tr>
            </table>
         </form>
      </section>

      <h3> Nombres d'annonces disponibles : 
         <?php
            $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
            $reponse4 = $bdd->query('SELECT COUNT(*) AS nbr_annonce FROM annonces WHERE annonce_active = 1');
            while ($donnees4 = $reponse4->fetch() ) {
               echo '<strong>' . htmlspecialchars($donnees4['nbr_annonce']) . '</strong>';
            } ?> 
      </h3>

      <?php include 'partie/footer.php'; ?>

   </body>
</html>