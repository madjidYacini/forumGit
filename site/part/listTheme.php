<?php
        $vide=true;
            echo '<!--liste des objets-->
            <div id="listObjet" class="col l12 s12 row card-panel">
                <!--objets de la question-->
                <div id="titleTheme" class="col s4 row">
                    <h1>'. htmlspecialchars($_GET["domaine"]) .'</h1>
                </div>';
    try{
         $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
         $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
         $bdd->exec('set names utf8');

         $req = $bdd->prepare('SELECT q.id_question, q.supprime, titre_quest, DATE_FORMAT(date_quest, "%d/%m/%Y %H:%i:%s") AS date_q, pseudo FROM question q,user u WHERE q.email=u.email AND nom_domaine=? AND q.supprime=0 ORDER BY date_quest ASC');
         $req->execute(array(htmlspecialchars($_GET["domaine"])));

            while ($donnees = $req->fetch()){
                $vide=false;  //s'il ya des questions poser  
                echo '<!--question-->
                <div class="col s12 row question">
                    <div class="col s9">';
                        if((isset($_SESSION["type"])) && (strcmp($_SESSION["type"],"a")==0)){
                          echo '<a href="question.php?domaine='. htmlspecialchars($_GET["domaine"]) .'&amp;id_quest='. $donnees["id_question"] .'">';
                        }
                        else{ echo '<a href="Question.php?domaine='. htmlspecialchars($_GET["domaine"]) .'&amp;id_quest='. $donnees["id_question"] .'">'; }

                      echo '<h3>'. htmlspecialchars($donnees["titre_quest"]) .'</h3>
                            <p>Par <strong>'. $donnees["pseudo"].'</strong> '. $donnees["date_q"] .'</p>
                        </a>
                    </div>
                    <div class="col s3 nbMessage">';
                    $reponse = $bdd->prepare('SELECT id_question, COUNT(DISTINCT id_rep) AS nbrep FROM reponse r WHERE id_question=? AND supprime=0 GROUP BY id_question');
                    $reponse->execute(array($donnees["id_question"]));
                    if ($data = $reponse->fetch()){
                        if ($data["nbrep"]>1){
                            echo '
                                <pre>'. ($data["nbrep"]+1) .' messages </pre>';
                        }
                        else{
                            echo '<pre>'. ($data["nbrep"]+1) .' messages</pre>';
                        }
                    }
                    else { echo '<pre>1 message </pre>'; }

                echo '</div>
                </div>';
                $reponse->closeCursor();
            }
            if ($vide){
                echo '<div class="col s12 row question">
                        <h4 class="center-align" >Aucune question posez dans ce forum</h4>
                    </div>';
            }
          $req->closeCursor();

        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }
    echo '</div>';
?>
