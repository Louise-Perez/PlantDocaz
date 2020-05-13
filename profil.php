<?php
    session_start();   
    $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');

    if(isset($_SESSION['id'])) {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
        $requser->execute(array($_SESSION['id']));
        $user = $requser->fetch();
        // Mis à jour Pseudo // 
        if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo_membres']) {
            $newpseudo = htmlspecialchars($_POST['newpseudo']);
            $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo_membres = ? WHERE id = ?");
            $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        // Mis à jour Nom // 
        if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom_membres']) {
            $newnom = htmlspecialchars($_POST['newnom']);
            $insertnom = $bdd->prepare("UPDATE membres SET nom_membres = ? WHERE id = ?");
            $insertnom->execute(array($newnom, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        // Mis à jour Prénom // 
        if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom_membres']) {
            $newprenom = htmlspecialchars($_POST['newprenom']);
            $insertprenom = $bdd->prepare("UPDATE membres SET prenom_membres = ? WHERE id = ?");
            $insertprenom->execute(array($newprenom, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        // Mis à jour Ville // 
        if(isset($_POST['newville']) AND !empty($_POST['newville']) AND $_POST['newville'] != $user['ville_membres']) {
            $newville = htmlspecialchars($_POST['newville']);
            $insertville = $bdd->prepare("UPDATE membres SET ville_membres = ? WHERE id = ?");
            $insertville->execute(array($newville, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        // Mis à jour Mail // 
        if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail_membres']) {
            $newmail = htmlspecialchars($_POST['newmail']);
            $insertmail = $bdd->prepare("UPDATE membres SET mail_membres = ? WHERE id = ?");
            $insertmail->execute(array($newmail, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        // Mis à jour Mot de passe  // 
        if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
            $mdp1 = sha1($_POST['newmdp1']);
            $mdp2 = sha1($_POST['newmdp2']);
            if($mdp1 === $mdp2) {
                $insertmdp = $bdd->prepare("UPDATE membres SET mdp = ? WHERE id = ?");
                $insertmdp->execute(array($mdp1, $_SESSION['id']));
                header('Location: profil.php?id='.$_SESSION['id']);
            } else {
                $msg = "Vos deux mdp ne correspondent pas !";
            }
        }
?>


<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - PLANTDOCAZ</title>
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


    <section class="edition_profil">
        <h2>Edition de mon profil</h2>
        
        <section class="encart_profil">
        <?php if(isset($msg)) { echo $msg; } ?>      
        <form method="POST" action="" enctype="multipart/form-data">
               <table>
                    <tr>
                        <td align="right">
                            <label>Pseudo :</label>
                        </td>
                        <td>
                            <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo_membres']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Nom :</label>
                        </td>
                        <td>
                            <input type="text" name="newnom" placeholder="Nom" value="<?php echo $user['nom_membres']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Prenom :</label>
                        </td>
                        <td>
                            <input type="text" name="newprenom" placeholder="Prenom" value="<?php echo $user['prenom_membres']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Ville:</label>
                        </td>
                        <td>
                            <input type="text" name="newville" placeholder="Ville" value="<?php echo $user['ville_membres']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Mail :</label>
                        </td>
                        <td>    
                            <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail_membres']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" name="newmdp1" placeholder="Mot de passe"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label>Confirmation - mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                            <br />
                            <input type="submit" value="Mettre à jour mon profil !" />
                        </td>
                    </tr>
                </table>
        </form>
        </section>
    </section>

    <section id="mes_annonces">    
        <h2>Mes annonces</h2>
            
            <section class="annonces">
                <?php   // Afficher la base de données
                $bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');
                $reponse = $bdd->query('SELECT * FROM annonces WHERE annonce_active = 1 AND id_membres="'.$_SESSION['id'].'"');
                if($reponse->rowCount() > 0) {
                    $reponse = $bdd->query('SELECT * FROM annonces WHERE annonce_active = 1 AND id_membres="'.$_SESSION['id'].'"');
                    while ($donnees = $reponse->fetch() ) { ?>
                        <div class="encart_annonce">
                            <p><strong class="information_annonce"> Nom: </strong><?php echo htmlspecialchars($donnees['nom_plante'])?></p>
                            
                            <form method="POST" action="" enctype="multipart/form-data"> 
                                <input type="radio" name="corbeille" class="corbeille" value="0"/>
                                <input type="submit" value="Supprimer l\'annonce"/>
                            </form>
                            
                            <p><strong class="information_annonce">Descripion de l'annonce : </strong></p>
                            <p><?php echo htmlspecialchars($donnees['description_annonce']) ?></p>
                            <p><strong class="information_annonce"> Ville: </strong><?php echo htmlspecialchars($donnees['ville_annonce'])?></p>
                            <p class="publication_annonce"><strong class="information_annonce"> Date de publication: </strong>
                            <?php echo htmlspecialchars($donnees['date_ajout'])?></p>
                            
                            <?php // FOREIGN KEY // 
                            $reponse2 = $bdd->query("SELECT pseudo_membres FROM membres INNER JOIN annonces ON membres.id = ".$donnees['id_membres']);
                            $donnees2 = $reponse2->fetch(); ?>
                            <p class="auteur_annonce"><strong class="information_annonce"> Auteur: </strong><?php echo htmlspecialchars($donnees2[0])?></p>
                            <?php
                            $reponse3 = $bdd->query("SELECT mail_membres FROM membres INNER JOIN annonces ON membres.id = ".$donnees['id_membres']);
                            $donnees3 = $reponse3->fetch(); ?>
                            <p class="contact_annonce"><strong class="information_annonce"> Contact: </strong><?php echo htmlspecialchars($donnees3[0]) ?></p>
                            
                            <br/>
                        </div>
                    <?php 
                    }
                }
                else { ?>
                    <p style="color: black;">Vous n'avez pas d'annonces en cours </p>
                <?php } 

                if(isset($_POST['corbeille'])){
                    $annonce_active = htmlspecialchars($_POST['corbeille']);
                    $insertactif = $bdd->prepare('UPDATE annonces SET annonce_active = ? WHERE id= ? ');
                    $insertactif->execute(array($annonce_active, $_SESSION['id']));
                    echo '<p style="color: red;"> Cette opération peut prendre quelques minutes </p>';
                }

                $reponse->closeCursor();
                ?>
            </section> 
    </section> 
    <?php include 'partie/footer.php'; ?>
    </body> 
</html>

<?php  
} 
    else {
        header("Location: connexion.php");
    }
?>