<?php
       echo '<!--liste des forums-->
        <div class="row col s11 s11 offset-s1 listForum">';
      try{
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
         $bdd->exec('set names utf8');
         $reponse = $bdd->query('SELECT * FROM domaine');
            while ($donnees = $reponse->fetch()){
                echo '<div class="col l3 m5 s12 theme" style="margin-left:0px;">';
                  if((isset($_SESSION["type"])) && (strcmp($_SESSION["type"],"a")==0)){
                    echo '<a href="theme.php?domaine=' . $donnees["nom_domaine"] . '">';
                  }
                  else{ echo '<a href="Theme.php?domaine=' . $donnees["nom_domaine"] . '">'; }
                        echo '<!--thème-forum title-->
                              <h3>' . htmlspecialchars($donnees["nom_domaine"]) . '</h3>
                              <hr>
                              <!--thème-forum description-->
                              <h5>'. htmlspecialchars($donnees["description"]) .'</h5>
                          </a>
                      </div>';
            }
          $reponse->closeCursor();
        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }
        echo '</div>';
?>
