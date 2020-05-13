<?php 
session_start();
?>
<?php
$bdd = new PDO('mysql:host=localhost;dbname=plantdocaz', 'root', 'root');

if(isset($_POST['forminscription'])) {
   $pseudo_membres = htmlspecialchars($_POST['pseudo_membres']);
   $nom_membres = htmlspecialchars($_POST['nom_membres']);
   $prenom_membres = htmlspecialchars($_POST['prenom_membres']);
   $code_postal_membres = htmlspecialchars($_POST['code_postal_membres']);
   $mail_membres = htmlspecialchars($_POST['mail_membres']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
      if(!empty($_POST['recaptcha-response'])) {
         $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LeTYfUUAAAAAMK5rXFZ3Rmwo3Ll6itLndYS0-fF&response={$_POST['recaptcha-response']}";
         $response = file_get_contents($url);
            if(empty($response) || is_null($response)) {
               header('Location: inscription.php');
            }
            else {
               $data = json_decode($response);
               if ($data-> success) {
                  if(!empty($_POST['pseudo_membres']) AND !empty($_POST['nom_membres']) AND !empty($_POST['prenom_membres']) AND !empty($_POST['code_postal_membres']) AND !empty($_POST['ville_membres']) AND !empty($_POST['mail_membres']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
                     $ville_membres = htmlspecialchars($_POST['ville_membres']);
                     $pseudo_membreslength = strlen($pseudo_membres);
                     $nom_membreslength = strlen($nom_membres);
                     $prenom_membreslength = strlen($prenom_membres);
                     if($pseudo_membreslength <= 255) {
                        if($nom_membreslength <= 255) {
                           if($prenom_membreslength <= 255) {       
                                 if(filter_var($mail_membres, FILTER_VALIDATE_EMAIL)) {
                                    $reqmail_membres = $bdd->prepare("SELECT * FROM membres WHERE mail_membres = ?");
                                    $reqmail_membres->execute(array($mail_membres));
                                    $mail_membresexist = $reqmail_membres->rowCount();
                                    if($mail_membresexist == 0) {
                                       if($mdp == $mdp2) {
                                          $insertmbr = $bdd->prepare("INSERT INTO membres(nom_membres, prenom_membres, pseudo_membres, mail_membres, code_postal_membres, ville_membres,  mdp) VALUES(?, ?, ?, ?, ?, ?, ?)");
                                          $insertmbr->execute(array($nom_membres, $prenom_membres, $pseudo_membres, $mail_membres, $code_postal_membres, $ville_membres,  $mdp));
                                          $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                                       } 
                                       else {
                                          $erreur = "Vos mots de passes ne correspondent pas !";
                                       }
                                    }    
                                    else {
                                       $erreur = "Adresse mail déjà utilisée !";
                                    }
                                 } 
                                 else {
                                    $erreur = "Votre adresse mail n'est pas valide !";
                                 }
                           } 
                           else {
                              $erreur = "Votre Prenom ne doit pas dépasser 255 caractères !";
                           }
                        } 
                        else {
                           $erreur = "Votre Nom ne doit pas dépasser 255 caractères !";
                        }
                     } 
                     else {
                        $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
                     }
                  } 
                  else {
                     $erreur = "Tous les champs doivent être complétés !";
                  }
               }
               else {
                  $erreur = "Vou devez êtes un robot ? Sinon rééssayez";
               }
            }
      } else {
         $erreur = " Vous devez êtes un robot ? Sinon rééssayez";
      }
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - PLANTDOCAZ</title>
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
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="deconnexion.php">   <?php  
               if ($_SESSION){
                  echo 'Se déconnecter'; 
               } 
               else {
                   echo '';
               }?></a></li>
         </ul>
     </header>


      <section>
           <h2>Inscription</h2>

           <?php
            if(isset($erreur)) {
               echo '<font color="red">'.$erreur."</font>";
            }
         ?>
               <section class="encart_inscription">
   
                  <form action="" method="POST">
                     <table>
                        <!-- Pseudo --> 
                        <tr>
                           <td align="right">
                              <label for="pseudo_membres">Pseudo :</label>
                           </td>
                           <td>
                              <input type="text" placeholder="Votre pseudo" id="pseudo_membres" name="pseudo_membres" value="<?php if(isset($pseudo_membres)) { echo $pseudo_membres; } ?>" />
                           </td>
                        </tr>
                        <!-- Nom --> 
                        <tr>
                           <td align="right">
                              <label for="nom_membres">Nom : </label>
                           </td>
                           <td>
                              <input type="text" placeholder="Votre Nom" id="nom_membres" name="nom_membres" value="<?php if(isset($nom_membres)) { echo $nom_membres; } ?>" />
                           </td>
                        </tr>
                        <!-- Prenom --> 
                        <tr>
                           <td align="right">
                              <label for="prenom_membres">Prenom : </label>
                           </td>
                           <td>
                              <input type="text" placeholder="Votre Prénom" id="prenom_membres" name="prenom_membres" value="<?php if(isset($prenom_membres)) { echo $prenom_membres; } ?>" />
                           </td>
                        </tr>
                        <!-- Code postal--> 
                        <tr>
                           <td align="right">
                              <label for="code_postal_membres">Code postal :</label>
                           </td>
                           <td>
                              <input type="text" placeholder="Votre code postal" id="code_postal_membres" name="code_postal_membres" value="<?php if(isset($code_postal_membres)) { echo $code_postal_membres; } ?>" />
                           </td>
                        </tr>
                        <!-- Ville--> 
                        <tr>
                           <td align="right">
                              <label for="ville_membres">Ville :</label>
                           </td>
                           <td>
                              <select name="ville_membres" id="ville_membres">
                              </select>
                            </td>
                        </tr>
                        <!-- Mail --> 
                        <tr>
                           <td align="right">
                              <label for="mail_membres">Mail :</label>
                           </td>
                           <td>
                              <input type="email" placeholder="Votre mail" id="mail_membres" name="mail_membres" value="<?php if(isset($mail_membres)) { echo $mail_membres; } ?>" />
                           </td>
                        </tr>
                        <!-- Mot de passe --> 
                        <tr>
                           <td align="right">
                              <label for="mdp">Mot de passe :</label>
                           </td>
                           <td>
                              <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                           </td>
                        </tr>
                        <!-- Mot de passe --> 
                        <tr>
                           <td align="right">
                              <label for="mdp2">Confirmation du mot de passe :</label>
                           </td>
                           <td>
                              <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                           </td>
                        </tr>
                        <!-- reCAPTCHA (je ne suis pas un robot)-->
                        <tr>
                           <td align="right">
                           </td>
                           <td>
                              <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                           </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td align="center">
                           <br />
                              <input type="submit" name="forminscription" value="Je m'inscris" />
                           </td>
                        </tr>
                        

                        <tr><td></td><td></td></tr>
                        <tr>
                           <td></td>
                           <td align="center">
                              <br />
                              <a href="connexion.php">Déjà inscrit ? Se connecter</a>
                           </td>
                        </tr>
                     </table>
                  </form>
               </section>
      </section>

      <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

  <script src="./JS/apiVille.js"></script>
   
  <script src="https://www.google.com/recaptcha/api.js?render=6LeTYfUUAAAAAOJjB_WS6yFx9Nt2ZYbU3Cev_OuC"></script>
   <script>
   grecaptcha.ready(function() {
      grecaptcha.execute('6LeTYfUUAAAAAOJjB_WS6yFx9Nt2ZYbU3Cev_OuC', {action: 'homepage'}).then(function(token) {
         document.getElementById("recaptchaResponse").value = token
      });
   });
   </script>

      <?php include 'partie/footer.php'; ?>
   </body>
</html>