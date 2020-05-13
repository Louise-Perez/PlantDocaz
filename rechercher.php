<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher - PLANTDOCAZ</title>
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

    <h1> Nos annonces </h1>

    <section class="encart_recherche">
        <form method="POST" action="">
            <label> Rechercher par nom de plante : </label> 
            <input type="text" name="recherche_nom" placeholder="Nom">
            <!-- <label> Rechercher par ville : </label> 
            <input type="text" name="recherche_ville"> -->
            <input type="SUBMIT" value="Rechercher"> 
        </form> 
    </section>

    <!-- Resultat de la recherche --> 
    <?php
            $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
            if (isset($_POST['recherche_nom']) AND !empty($_POST['recherche_nom'])) {
                $recherche_nom = htmlspecialchars($_POST['recherche_nom']);
                $reponse_nbr = $bdd->query('SELECT COUNT(*) AS nbr_annonce FROM annonces WHERE nom_plante LIKE "%$recherche_nom%"');
                while ($donnee = $reponse_nbr->fetch()) { ?>
                    <h3> Résultat de votre recherche : </h3>
                <?php
                } 
            }
    ?> 



    <section class="annonces"> <!-- Section recherche -->
        <?php
            $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');

            // RECHERCHE PAR VILLE // 
            // else if (isset($_POST['recherche_ville']) AND !empty($_POST['recherche_ville']) AND empty($_POST['recherche_nom'])) {
            //     $recherche_ville = htmlspecialchars($_POST['recherche_ville']);
            //     $reponse = $bdd->query('SELECT ville_annonce FROM annonces WHERE ville_annonce LIKE "%$recherche_ville%" LIMIT 10');
            //     if($reponse->rowCount() == 0) {
            //         $reponse = $bdd->query('SELECT ville_annonce FROM annonces WHERE CONCAT(ville_annonce) LIKE "%'.$recherche_ville.'%" ORDER BY id DESC');
            //     }
            // }

            // RECHERCHE PAR NOM // 
            if (isset($_POST['recherche_nom']) AND !empty($_POST['recherche_nom'])) {
                $recherche_nom = htmlspecialchars($_POST['recherche_nom']);
                $reponse = $bdd->query('SELECT * FROM annonces WHERE annonce_active = 1 AND nom_plante LIKE "%$recherche_nom%"');
                if($reponse->rowCount() >= 0) {
                    $reponse = $bdd->query('SELECT * FROM annonces WHERE annonce_active = 1 AND CONCAT(nom_plante) LIKE "%'.$recherche_nom.'%" ORDER BY id DESC');
                        while($donnees = $reponse->fetch()) { ?>
                            <div class="encart_annonce">
                                <p><strong class="information_annonce"> Nom: </strong>
                                    <?php echo htmlspecialchars($donnees['nom_plante'])?></p>
                                <p><strong class="information_annonce">Descripion de l'annonce : </strong></p>
                                    <p><?php echo htmlspecialchars($donnees['description_annonce'])?></p>
                                <p><strong class="information_annonce"> Ville: </strong>
                                    <?php echo htmlspecialchars($donnees['ville_annonce']) ?></p>
                                <p class="publication_annonce"><strong class="information_annonce"> Date de publication: </strong>
                                    <?php echo htmlspecialchars($donnees['date_ajout'])?></p>

                                <?php // Clé étangère // 
                                $reponse2 = $bdd->query("SELECT pseudo_membres FROM membres INNER JOIN annonces ON membres.id = ".$donnees['id_membres']);
                                $donnees2 = $reponse2->fetch(); ?>
                                    <p class="auteur_annonce"><strong class="information_annonce"> Auteur: </strong>
                                        <?php echo htmlspecialchars($donnees2[0])?></p>
                                <?php if ($_SESSION){
                                    $reponse3 = $bdd->query("SELECT mail_membres FROM membres INNER JOIN annonces ON membres.id = ".$donnees['id_membres']);
                                    $donnees3 = $reponse3->fetch(); ?>
                                    <p class="contact_annonce"><strong class="information_annonce"> Contact: </strong>
                                        <?php echo htmlspecialchars($donnees3[0])?></p>
                                <?php } else { ?>
                                    <p class="contact_annonce">
                                        <strong class="information_annonce"> Contact: </strong> 
                                        Vous devez être connecter
                                    </p>';
                                <?php } ?>
                                <br/>
                            </div>
                        <?php } 
                    }
                else { 
                    echo 'Aucun résultat ';
                } 
            }
        ?> 
   </section>

   <hr/> 
    <!-- Toutes les annonces  -->
   <h3> Nombres d'annonces disponibles : 
        <?php
            $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
            $reponse4 = $bdd->query('SELECT COUNT(*) AS nbr_annonce FROM annonces WHERE annonce_active = 1');
            while ($donnees4 = $reponse4->fetch() ) {
               echo '<strong>' . htmlspecialchars($donnees4['nbr_annonce']) . '</strong>';
            } ?> 
    </h3>

    <section class="annonces">
        <?php   // Afficher la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
            $reponse = $bdd->query('SELECT * FROM annonces WHERE annonce_active = 1');
            while ($donnees = $reponse->fetch() ) { ?>
                <div class="encart_annonce">
                    <p><strong class="information_annonce"> Nom: </strong>
                        <?php echo htmlspecialchars($donnees['nom_plante'])?></p>
                    <p><strong class="information_annonce">Descripion de l'annonce : </strong></p>
                        <p><?php echo htmlspecialchars($donnees['description_annonce'])?></p>
                    <p><strong class="information_annonce"> Ville: </strong>
                        <?php echo htmlspecialchars($donnees['ville_annonce'])?></p>
                    <p class="publication_annonce"><strong class="information_annonce"> Date de publication: </strong>
                        <?php echo htmlspecialchars($donnees['date_ajout'])?></p>
                    <?php // FOREIGN KEY //
                    $reponse2 = $bdd->query("SELECT pseudo_membres FROM membres INNER JOIN annonces ON membres.id = ".$donnees['id_membres']);
                    $donnees2 = $reponse2->fetch(); ?>
                    <p class="auteur_annonce"><strong class="information_annonce"> Auteur: </strong>
                        <?php echo htmlspecialchars($donnees2[0])?></p>
                    <?php if ($_SESSION){
                        $reponse3 = $bdd->query("SELECT mail_membres FROM membres INNER JOIN annonces ON membres.id = ".$donnees['id_membres']);
                        $donnees3 = $reponse3->fetch(); ?>
                        <p class="contact_annonce"><strong class="information_annonce"> Contact: </strong>
                            <?php echo htmlspecialchars($donnees3[0])?></p>
                        <?php } else { ?>
                        <p class="contact_annonce"><strong class="information_annonce"> Contact: </strong> Vous devez être connecter</p>
                        <?php } ?>
                    <br/>
                </div>
            <?php } 
            $reponse->closeCursor();
        ?>
    </section> 

    <?php include 'partie/footer.php'; ?>

</body>
</html>

