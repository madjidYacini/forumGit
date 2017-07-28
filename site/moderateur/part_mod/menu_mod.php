<?php
try{
  $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
  $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
  $reponse = $bdd->query('SELECT
    (SELECT COUNT(*) FROM user WHERE type="u") AS nb_user,
    (SELECT COUNT(*) FROM user WHERE bloquer=1) AS nb_user_b,
    (SELECT COUNT(*) FROM question WHERE supprime=1) AS nb_quest_sup,
    (SELECT COUNT(DISTINCT id_question) FROM signaler_quest ) AS nb_quest_sign  ,
    (SELECT COUNT(DISTINCT id_rep) FROM signaler_rep ) AS nb_rep_sign ,
    (SELECT COUNT(*) FROM reponse WHERE supprime=1) AS nb_rep_sup');
    if($donnees = $reponse->fetch()){

      echo'<div class="row" id="complete">

          <!--la barre de navigation-->
          <div id="slide-out" class="side-nav fixed #eeeeee grey lighten-3">

                <!--le logo de la biblio-->
                <div id="logo" style="margin-bottom: 50px;">
                    <img src="../img/logo2.png" class="responsive-img" alt="">
                </div>

                <a href="./forum.php" class="btn_menu">Forums</a>

                <a href="./repSignaler.php" class="btn_menu"><span class="badge new">'.$donnees["nb_rep_sign"].'</span>Réponses signalées</a>

                <a href="./repSupprimer.php" class="btn_menu"><span class="badge new">'.$donnees["nb_rep_sup"].'</span>Réponses supprimées</a>

                <a href="./questSignaler.php" class="btn_menu"><span class="badge new ">'.$donnees["nb_quest_sign"].'</span>Questions signalées</a>
                <a href="./questSupprimer.php" class="btn_menu"><span class="badge new">'.$donnees["nb_quest_sup"].'</span>Questions supprimées</a>

                <a href="./userBloquer.php" class="btn_menu"><span class="badge new">'.$donnees["nb_user_b"].'</span>Utilisateurs bloqués</a>
                <a href="./user.php" class="btn_menu"><span class="new badge" data-badge-caption="">'.$donnees["nb_user"].'</span>Liste utilisateur</a>
                <a href="./annonce.php" class="btn_menu"><span class="new badge" data-badge-caption=""></span>ajouter une annonce</a>
          </div>

            <!--principale-->
            <div id="principale" class="col s12">
                <style>
                    #slide-out .btn_menu{
                        font-size:1em;
                        z-index:2;
                    }
                    .new.badge{
                        opacity:0.4;
                    }
                    .new.badge:hover{
                        z-index:100;
                    }
                    @media screen and (min-width:993px){
                        /*principale*/
                        #principale{
                            margin-left: 320px;
                        }
                </style>';

     }
     $reponse->closeCursor();
  }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
     ?>
