<?php
    session_start();
    //si un modérateur essaie d'entrée dans cette espace par un lien
    if( isset($_SESSION["type"]) && strcmp($_SESSION["type"],"a")==0 ){
      header('location: ./moderateur/forum.php');
    }
    //si l'utilistaeur est bloquer durant sa connexion
    if (isset($_SESSION["email"])){
      try{
          $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
          $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
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
    <title >Forum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" sizes="144x144" href="./img/logo_bibliotheque_fr.ico">
    <link rel="stylesheet" type="text/css" href="framework/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Forum.css">
    <link rel="stylesheet" type="text/css" href="assets/css/breadcrumb.css">
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
    echo   '<!--chemin-->
            <div class="chemin">
                <a href="Forum.php" class="breadcrumb black-text" >Forum</a>
            </div>';
    echo '<!--image et boutton-->
            <div id="imageButton" class="col l12 s12 hide-on-large-only">
                <!--bouton menu large-->
                <a href="#" data-activates="slide-out" id="bouttonMenu" class="button-collapse">☰</a>
            </div>

            <!--conteneur des forums-->
            <div class="col s12 row card-panel" id="contenerForum">

                <!--grand titre-->
                <div class="row col s12 bigTitle">
                    <h1 >Liste des forums</h1>
                </div>';
        include("./part/listForum.php");

        echo '</div>';
        include("./part/footer.html");
        include("./part/boite.php");

?>
