<?php
    session_start();
?>
<?php
    try{
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
        $bdd->exec('set names utf8');
        $req = $bdd->prepare('SELECT id_rep, email FROM signaler_rep WHERE id_rep=? AND email=?');
        $req->execute(array($_POST["id_rep"],$_SESSION["email"]));
        if ($donnees = $req->fetch()){
            //si l'user a signaler déjà cette réponse
            $_SESSION["signalerRep"]=1;
            if(strcmp($_SESSION["type"],"a")==0){
                header('location: ../moderateur/question.php?domaine='. $_POST["domaine"] .'&id_quest='.$_POST["id_quest"]);
            }
            else{ header('location: ../Question.php?domaine='. $_POST["domaine"] .'&id_quest='.$_POST["id_quest"]); }
            $req->closeCursor();
        }
        else{
            try{
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
                $bdd->exec('set names utf8');
                $reponse = $bdd->prepare('INSERT INTO signaler_rep(email, id_rep, date_signal) VALUES ( ?, ?,NOW())');
                $reponse->execute(array($_SESSION["email"], $_POST["id_rep"]));
                $_SESSION["signalerRep"]=2;
                if(strcmp($_SESSION["type"],"a")==0){
                    header('location: ../moderateur/question.php?domaine='. $_POST["domaine"] .'&id_quest='.$_POST["id_quest"]);
                }
                else{ header('location: ../Question.php?domaine='. $_POST["domaine"] .'&id_quest='.$_POST["id_quest"]); }
                $reponse->closeCursor();
            }
            catch (Exception $e){
                die('Erreur : ' . $e->getMessage());
            }
        }

    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
?>
