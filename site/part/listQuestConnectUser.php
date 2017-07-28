<?php
        //la question pour user simple
        $vide=true;
        echo '<!--discussion-->
            <div id="discussion" class="col l12 s12 row card-panel">

                <!--Titre de théme-->
                <div id="titleDiscussion" class="col s12 row">';
        try{
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
         $bdd->exec('set names utf8');
         $reponse = $bdd->prepare('SELECT id_question, titre_quest FROM question WHERE id_question=?');
         $reponse->execute(array($_GET["id_quest"]));
            $donnees = $reponse->fetch();
                echo '<h1>'. htmlspecialchars($donnees["titre_quest"]) .'</h1>';
                $reponse->closeCursor();
        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }

        echo '</div>';

        // la liste des réponse associé à la question posée
        try{
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
         $bdd->exec('set names utf8');
         $reponse = $bdd->prepare('SELECT id_question, supprime, question, DATE_FORMAT(date_quest, "%d/%m/%Y à %H:%i:%s") AS date_q, pseudo FROM question q,user u WHERE q.email=u.email AND nom_domaine=? AND id_question=? AND supprime=0');
         $reponse->execute(array($_GET["domaine"],$_GET["id_quest"]));
            while ($donnees = $reponse->fetch()){
                    $vide=false;
                    echo "<!--Discussion-->
                    <div class='col s12 message'>
                        <!--auteur&image-->
                        <div class='col l2 m2 s12 auteur'>
                            <p>". $donnees["pseudo"] ."</p>
                            <div class='col s12 center-align'>
                              <img src='img/avatar_defaut.png' class='responsive-img' alt=''>
                            </div>
                        </div>
                        <!--date&réponse-->
                        <div class='col l9 m9 s11 answer'>
                            <div class='col s12 row'>
                                <span class='reponse'>". nl2br($donnees["question"]) ."</span>
                            </div>
                            <pre class='col s12 row'>". $donnees["date_q"] ."</pre>
                        </div>";
                        //boutton signaler une question
                          echo "<form action='./part/signalerQuest.php' method='post' class='col s1 right-align'>
                                <input type='submit' style='font-size:20px; border:none; background-color:transparent' title='Signaler' value='&#9888;'>
                                <input type='hidden' name='id_quest' value='". $donnees["id_question"] ."'>
                                <input type='hidden' name='domaine' value='". htmlspecialchars($_GET["domaine"]) ."'>
                            </form>";
                    echo "</div>";

            }
            if ($vide){
                echo '<div class="col s12 row #e0e0e0 grey lighten-2" style="margin-top:64px;">
                        <h4  class="center-align">Cette discussion a été supprimée</h4>
                    </div>';
            }
            $reponse->closeCursor();
        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }

        try{
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
         $bdd->exec('set names utf8');
         $reponse = $bdd->prepare('SELECT id_question ,id_rep,rep, supprime, DATE_FORMAT(date_rep, "%d/%m/%Y à %H:%i:%s") AS date_r, pseudo FROM user u,reponse r WHERE r.email=u.email AND id_question=? AND supprime=0 ORDER BY date_rep ASC');
         $reponse->execute(array($_GET["id_quest"]));
            while ($donnees = $reponse->fetch()){
                    echo "<!--Discussion-->
                    <div class='col s12 message'>
                        <!--auteur&image-->
                        <div class='col l2 m2 s12 auteur'>
                            <p>". $donnees["pseudo"] ."</p>
                            <div class='col s12 center-align'>
                              <img src='img/avatar_defaut.png' class='responsive-img' alt=''>
                            </div>
                        </div>
                        <!--date&réponse-->
                        <div class='col l9 m9 s11 answer'>
                            <div class='col s12 row'>
                                <span class='reponse'>". nl2br($donnees["rep"]) ."</span>
                            </div>
                            <pre class='col s12 row'>". $donnees["date_r"] ."</pre>
                        </div>";
                        //boutton signaler une réponse
                        echo "<form action='./part/signalerRep.php' method='post' class='col s1 right-align'>
                                <input type='submit' title='Signaler' value='&#9888;' style='font-size:20px; border:none; background-color:transparent'>
                                <input type='hidden' name='id_rep' value='". $donnees["id_rep"] ."'>
                                <input type='hidden' name='domaine' value='". htmlspecialchars($_GET["domaine"]) ."'>
                                <input type='hidden' name='id_quest' value='". htmlspecialchars($_GET["id_quest"]) ."'>
                            </form>";

                    echo "</div>";
                }
            echo '</div>';
          $reponse->closeCursor();
        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }
?>
