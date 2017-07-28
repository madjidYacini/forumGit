<?php
    session_start();
    //si un modérateur essaie d'entrée dans cette espace par un lien
    if( isset($_SESSION["type"]) && strcmp($_SESSION["type"],"a")==0 ){
      header('location: ./moderateur/question.php?domaine='. htmlspecialchars($_GET["domaine"]). '&id_quest='. htmlspecialchars($_GET["id_quest"]));
    }
?>
<?php
  if (isset($_GET["domaine"]) && isset($_GET["id_quest"])){
    try{
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mybd', 'id1227213_abc', '', $pdo_options);
        $bdd->exec('set names utf8');
        $rep = $bdd->prepare('SELECT nom_domaine, id_question, titre_quest FROM question WHERE id_question=? AND nom_domaine=?');
        $rep->execute(array(htmlspecialchars($_GET["id_quest"]),htmlspecialchars($_GET["domaine"])));
        if ($data = $rep->fetch()){
          //si la question existe dans la BDD
          $_SESSION["domaine"]=$data["nom_domaine"]; //pour l'édit,eur
          $_SESSION["id_quest"]=$data["id_question"]; //pour l'éditeur
          $_SESSION["pageCourante"]="question"; //pour l'éditeur

          //si l'utilistaeur est bloquer entrain de se connecter
          if (isset($_SESSION["email"])){
            try{
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mybd', 'id1227213_abc', '', $pdo_options);
                $bdd->exec('set names utf8');
                $reponse = $bdd->prepare('SELECT email, bloquer FROM user WHERE email=?');
                $reponse->execute(array($_SESSION["email"]));
                $donnees = $reponse->fetch();
                if ($donnees["bloquer"]==1){
                  session_unset();
                  $_SESSION["connect"]=0;
                  $_SESSION["deconnect"]=0;
                }
                $reponse->closeCursor();
              }
              catch (Exception $e){
                  die('Erreur : ' . $e->getMessage());
              }
            }
?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title><?php echo $data["titre_quest"]; ?></title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="icon" sizes="144x144" href="./img/logo_bibliotheque_fr.ico">
                <link rel="stylesheet" type="text/css" href="framework/materialize.min.css">
                <link rel="stylesheet" type="text/css" href="assets/css/main.css">
                <link rel="stylesheet" type="text/css" href="assets/css/Question.css">
                <link rel="stylesheet" type="text/css" href="assets/css/breadcrumb.css">
                <link rel="stylesheet" href="assets/css/editeurQuestUser.css">
            </head>
            <body>
<?php
    include("./part/barNav.html");
    if (isset($_SESSION["pseudo"])){
        include("./part/connect.php");
  }
  else{
        include("./part/desconnect.php");
    }
    echo '<div class="chemin">
             <a href="Forum.php"  class="breadcrumb #f4511e deep-orange-text">Forum</a>
             <a href="Theme.php?domaine='. htmlspecialchars($_GET["domaine"]) .'" class="breadcrumb #f4511e deep-orange-text">'. htmlspecialchars($_GET["domaine"]) .'</a>';
      try{
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mybd', 'id1227213_abc', '', $pdo_options);
         $bdd->exec('set names utf8');
         $reponse = $bdd->prepare('SELECT id_question, titre_quest FROM question WHERE id_question=?');
         $reponse->execute(array($_GET["id_quest"]));
            $donnees = $reponse->fetch();
                echo '<a href="" class="breadcrumb black-text hide-on-small-only">'. htmlspecialchars($donnees["titre_quest"]) .'</a>';
                $reponse->closeCursor();
        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }
        echo  '</div>';
?>


            <!--image et boutton-->
            <div id="imageButton" class="col l12 s12 hide-on-large-only">
                <!--bouton menu large-->
                <a href="#" data-activates="slide-out" id="bouttonMenu" class="button-collapse">☰</a>
            </div>

            <div id="liste">
            <?php
              if(isset($_SESSION["pseudo"])){
                include("./part/listQuestConnectUser.php");
              }
              else{
                include("./part/listQuestDesconnect.php");
              }
            ?>
            </div>
<?php

        if (isset($_SESSION["pseudo"])){
            echo '<!--ajouter une question/réponse-->
            <div class="col l10 offset-l1 m11 s12 row" style="margin-top: 50px;">

                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header" >Ecrire un message</div>
                      <div class="collapsible-body">
                        <iframe src="./part/editeur.php" id="editor" width="100%" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
                      </div>
                    </li>
                  </ul>

            </div>';
        }
        else{
            echo '<div class="col s12" style="margin-top:60px;margin-bottom:30px;">
                    <a href="#modal1" class="center-align white black-text" style="display:flex; flex-direction:row; justify-content:center;">
                      <img src="./img/alerte.png" style="width: 30px;vertical-align: middle;">
                      <span class="center-align tooltipped" data-position="bottom" data-delay="50" data-tooltip="Cliquer pour vous connecter" >Veuillez vous connecter pour répondre</span>
                    </a>
                  </div>';
        }
?>

        <!--image de scroll en haut-->
        <img src="img/scroll-to-top.png" alt="" id="scrollTop">

<?php include("./part/footer.html"); ?>
    <script>

        //pliante (ajout d\'une réponse/question)
        $(document).ready(function(){
            $(".collapsible").collapsible();
        });
        <?php
          //la fonction de rafraichissement
          if (isset($_SESSION["pseudo"])){
            echo '$(function(){
                setInterval(function() {
                    $("#liste").load("./part/listQuestConnectUser.php?domaine='.$_GET["domaine"].'&id_quest='.$_GET["id_quest"].'");
                }, 1000);
            });';
          }
          else{
            echo '$(function(){
                setInterval(function() {
                    $("#liste").load("./part/listQuestDesconnect.php?domaine='.$_GET["domaine"].'&id_quest='.$_GET["id_quest"].'");
                }, 1000);
            });';
          }

         ?>
    </script>
  <?php
            include("./part/boite.php");
            $rep->closeCursor();
        }
        else{
            header('location: ./part/erreur.html');
        }
    }
    catch (Exception $e){
         die('Erreur : ' . $e->getMessage());
    }
  }
    else{
        header('location: ./part/erreur.html');
    }
?>
