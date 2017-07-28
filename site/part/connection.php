<?php
    session_start();
?>
<?php
    //si les champs pseudo et mot de passe ne sont pas vide
    if (isset($_POST["pseudo"]) && isset($_POST["password"])){
        $pseudo = test($_POST["pseudo"]);
        $password = test($_POST["password"]);
        try{
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $bdd = new PDO('mysql:host=localhost;dbname=id1227213_mydb', 'id1227213_abc', '', $pdo_options);
            $bdd->exec('set names utf8');
            $reponse = $bdd->prepare('SELECT pseudo, mdp, email, bloquer, type FROM user WHERE pseudo=? AND mdp=?');
            $reponse->execute(array( $pseudo, $password));
            if ( $donnees = $reponse->fetch()){
                // si l'user existe dans la BDD
                if (strcmp($donnees["type"],"u")==0){
                    // si c'est un simple user
                    if ($donnees['bloquer']==1){
                        // s'il n'est pas bloquée
                        $_SESSION["connect"]=0;
                    } else {
                            $_SESSION["pseudo"]=$donnees["pseudo"];
                            $_SESSION["email"]=$donnees["email"];
                            $_SESSION["type"]="u";
                            $_SESSION["connect"]=2;
                        }
                }
                else{
                    //cas d'un modérateur
                    $_SESSION["pseudo"]=$donnees["pseudo"];
                    $_SESSION["email"]=$donnees["email"];
                    $_SESSION["type"]="a";
                    $_SESSION["connect"]=2;
                }
                //l'orientaion aprés connection
                if (strcmp($donnees["type"],"u")==0){
                    if (isset($_POST["id_quest"])){
                        header('location: ../Question.php?domaine='. $_POST["domaine"].'&id_quest='. $_POST["id_quest"]);
                    }
                    else{
                        if (isset($_POST["domaine"])){
                            header('location: ../Theme.php?domaine='. $_POST["domaine"]);
                        }
                        else header('location: ../Forum.php');
                    }
                }
                else {
                    header('location: ../moderateur/forum.php');
                }
            }
            else{
                //si l'user n'existe pas dans la BDD ou il à saisie des données erronées
                $_SESSION["connect"]=1;
                if (isset($_POST["id_quest"])){
                    header('location: ../Question.php?domaine='. $_POST["domaine"].'&id_quest='. $_POST["id_quest"]);
                }
                else{
                    if (isset($_POST["domaine"])){
                        header('location: ../Theme.php?domaine='. $_POST["domaine"]);
                    }
                    else header('location: ../Forum.php');
                }
            }
            $reponse->closeCursor();
        }
        catch (Exception $e){
             die('Erreur : ' . $e->getMessage());
        }
    }
    else{
          //si le pseudo ou mot de passe ne sont pas saisie
            $_SESSION["connect"]=1;
            if (isset($_POST["id_quest"])){
                header('location: ../Question.php?domaine='. $_POST["domaine"].'&id_quest='. $_POST["id_quest"]);
            }
            else{
                if (isset($_POST["domaine"])){
                    header('location: ../Theme.php?domaine='. $_POST["domaine"]);
                }
                else header('location: ../Forum.php');
            }
        }

    function test($data){
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
?>
