<?php

  // la barre de  menu horizontale pour un utilisateur connecté
  echo '<!--barre de menu-->
        <nav id="" class="#eeeeee grey lighten-3" style="height: 50px;line-height: 46px;">
            <div class="nav-wrapper">
                <div class="col s12 right-align">
                    <div id="connect">';
                    echo '<a  class="hide-on-small-only btn #f4511e deep-orange darken-1 waves-effect waves-purple" href="#modal2" style="margin-right:4px">deconnecter</a>';
                        if (strcmp($_SESSION["type"],"u")==0){
                            //utilisteur simple
                            echo '<a href="./compte.php"  class="hide-on-small-only btn #f4511e deep-orange darken-1 waves-effect waves-purple">compte</a>
                            <a href="" class="aide hide-on-small-only btn #f4511e deep-orange darken-1 waves-effect waves-purple">?</a>
                            <button id="paramaitre" class="hide-on-med-and-up btn #f4511e deep-orange darken-1 waves-effect waves-purple">&#128315;</button>
                              <div id="listParamaitre" class="card-panel">
                                <p id="fleche">&#128314;</p>
                                <a href="./compte.php" >Compte</a>
                                <a href="#modal2" >Deconnecter</a>
                                <a href="" class="aide" >Aide</a>
                              </div>';
                        }
                        else{
                            // modérateur
                            echo '<a href="./compteMod.php"  class="hide-on-small-only btn #f4511e deep-orange darken-1 waves-effect waves-purple">compte</a>
                                  <a href="./aideModerateur.php" class="hide-on-small-only aide btn #f4511e deep-orange darken-1 waves-effect waves-purple waves-effect waves-purple">?</a>
                                  <button id="paramaitre" class="hide-on-med-and-up btn #f4511e deep-orange darken-1 waves-effect waves-purple">&#128315;</button>
                                    <div id="listParamaitre" class="card-panel">
                                      <p id="fleche">&#128314;</p>
                                      <a href="./compteMod.php" >Compte</a>
                                      <a href="#modal2" >Deconnecter</a>
                                      <a href="./aideModerateur.php" class="aide" >Aide</a>
                                    </div>';
                        }
                echo '</div>
                </div>
            </div>
        </nav>';
        //la boite de dialogue de deconnection
        echo '<div id="modal2" class="modal">
                <div class="modal-content" style="border-bottom:1px solid gray;">
                    <h4 class="black-text left-align">Voulez-vous vraiment vous déconnecter?</h4>
                </div>
                <div class="modal-footer">';
                    if (isset($_GET["domaine"])){
                        if (isset($_GET["id_quest"])){
                          if(strcmp($_SESSION["type"],"u")==0){
                            echo '<a href="part/deconnection.php?domaine='. htmlspecialchars($_GET["domaine"]) .'&id_quest='. $_GET["id_quest"] .'" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1">deconnecter</a>';
                          }
                          else{
                            echo '<a href="../part/deconnection.php?domaine='. htmlspecialchars($_GET["domaine"]) .'&id_quest='. $_GET["id_quest"] .'" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1">deconnecter</a>';
                          }

                        }
                        else{
                          if(strcmp($_SESSION["type"],"u")==0){
                            echo '<a href="part/deconnection.php?domaine='. htmlspecialchars($_GET["domaine"]) .'" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1">deconnecter</a>';
                          }
                          else{
                            echo '<a href="../part/deconnection.php?domaine='. htmlspecialchars($_GET["domaine"]) .'" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1">deconnecter</a>';
                          }
                        }

                    }
                    else {
                        if (strcmp($_SESSION["type"],"u")==0){
                            echo '<a href="part/deconnection.php" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1">deconnecter</a>';
                        }
                        else{
                            echo '<a href="../part/deconnection.php" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1">deconnecter</a>';
                        }
                    }
                echo '<a href="" class="white-text modal-action modal-close waves-effect waves-green btn-flat #f4511e deep-orange darken-1" style="margin-right:6px">Annuler</a>
                </div>
            </div>';
?>
