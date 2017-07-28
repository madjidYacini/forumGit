<?php
    session_start();
    //si un modérateur essaie d'entrée dans cette espace par un lien

?>

    <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" sizes="144x144" href="../img/logo_bibliotheque_fr.ico">
            <link rel="stylesheet" type="text/css" href="../framework/materialize.min.css">
            <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
            <link rel="stylesheet" type="text/css" href="../assets/css/Theme.css">
            <link rel="stylesheet" type="text/css" href="../assets/css/breadcrumb.css">
            <link rel="stylesheet" href="../assets/css/editeurThemeUser.css">
        </head>
        <body>

<?php
    include("./part_mod/menu_mod.php");
    if (isset($_SESSION["pseudo"])){
        include("../part/connect.php");
  }
  else{
        include("../part/desconnect.php");
      }
    echo '<div class="chemin">
                <a href="Forum.php" class="breadcrumb #f4511e deep-orange-text" >Forum</a>
            </div>';
    echo '<!--image et boutton-->
            <div id="imageButton" class="col l12 s12 hide-on-large-only">
                <!--bouton menu large-->
                <a href="#" data-activates="slide-out" id="bouttonMenu" class="button-collapse">☰</a>
            </div>';
      echo '<div id="objet">';
      echo '</div>';


        echo '<!--ajouter une question-->
            <div class="col l10 offset-l1 m11 s12 row" style="margin-top: 50px;">

                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header" >Ajouter une annonce </div>
                      <div class="collapsible-body">
                          <iframe src="../part/ann_post.php" id="editor" width="100%" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
                      </div>
                    </li>
                  </ul>

            </div>';
   
    echo '<!--image de scroll en haut-->
            <img src="img/scroll-to-top.png" alt="" id="scrollTop">';
    include("./part_mod/footer.html");
?>
    <script>
        //pliante (ajout d'une question)
        $(document).ready(function(){
            $(".collapsible").collapsible();
        });

        //la fonction de rafraichissement
        $(function(){
            setInterval(function() {
                $('#objet').load('./part/listTheme.php?<?php echo 'domaine='.$_GET["domaine"]; ?>');
            }, 1000);
        });
    </script>
