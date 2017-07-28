<!DOCTYPE html>
    <html lang="fr">
    <head>
      <meta charset="UTF-8">
      <title>Accueil</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" sizes="144x144" href="./img/logo2.ico">
      <link rel="stylesheet" type="text/css" href="framework/materialize.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/main.css">
      <link rel="stylesheet" type="text/css" href="assets/css/calendrier.css">
      <script src="assets/js/calendrier.js"></script>
    </head>
    <body>
<?php include("./part/barNav.html"); ?>
    <!--image et boutton-->
    <div id="imageButton" class="col l12 s12">
      <!--boutton barre de navigation pour les petits moyens écrans-->
      <a href="#" data-activates="slide-out" id="bouttonMenu" class="button-collapse hide-on-large-only">☰</a>

      <!--image-->
      <div id="image" class="col s12">
          <img class="responsive-img" src="./img/image_principale1.png" id="pic" alt="livres">
      </div>

    </div>

    <!--annonce et calendrier-->
    <div id="annonceCalendrier" class="col l12 s12 row">

      <!--annonces-->
      <div id="annonces" class="col l7 m12 s12">
<?php
    try{
     $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
     $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', 'azerty');
     $bdd->exec("set names utf8");
     $reponse = $bdd->query('SELECT contenu_annonce,DATE_FORMAT(date_annonce, "%d/%m/%Y à %H:%i:%s") AS date FROM annonce');
        while ($donnees = $reponse->fetch()){
            echo '<span class="annonce">
                    <p class="flow-text">' . nl2br(htmlspecialchars($donnees['contenu_annonce'])) .'</p>
                    <pre class="right-align">'. $donnees['date'] .'</pre>
                    <hr>
                  </span>';
        }
      $reponse->closeCursor();
    }
    catch (Exception $e){
         die('Erreur : ' . $e->getMessage());
    }
?>
        </div>

      <!--calendrier-->
      <div class="col l5 s12">
          <!--calendrier-->
          <div class="hide-on-med-and-down">
              <script type="text/javascript">
                  calendrier();
              </script>
          </div>

          <!--slider-->
          <div class="slider col s12" id="slider">
              <ul class="slides">
                <li>
                  <img src="./img/shutterstock_140186863-1000x800.jpg">
                  <div class="caption center-align">
                  </div>
                </li>
                <li>
                  <img src="./img/bibliotheque2.jpg">
                  <div class="caption left-align">
                  </div>
                </li>
                <li>
                  <img src="./img/livre-troc.jpg">
                  <div class="caption right-align">
                  </div>
                </li>
                <li>
                  <img src="./img/la-bibliotheque.jpg">
                  <div class="caption center-align">
                  </div>
                </li>
              </ul>
            </div>

      </div>
    </div>

<?php    include("./part/footer.html"); ?>
<script>

      //slider
      $( document ).ready(function(){
          $(".slider").slider({full_width: true});
      });

      //positionnement de div d'annonce et calendrier
      $( document ).ready(function(){
          if ($(window).width()<=992){
              var marge=$("#pic").height();
              $("#annonceCalendrier").css("margin-top",marge);
          }
      });

      //positionnement de div d\'annonce et calendrier lors du redimensions de l\'écran
      $(window).resize(function(){
         if ($(window).width()<=992){
              var marge=$("#pic").height();
              $("#annonceCalendrier").css("margin-top",marge);
          }
          else {
              $("#annonceCalendrier").css("margin-top","auto");
          }
      });

    </script>
</body>
</html>
