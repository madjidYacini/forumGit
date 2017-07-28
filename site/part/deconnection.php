<?php
    session_start();
    session_unset();
    $_SESSION["deconnect"]=0;
    // l'orientation l'hors de la deconnection
    if (isset($_GET["id_quest"])){
        header('location: ../Question.php?domaine='. $_GET['domaine'].'&id_quest='. $_GET["id_quest"]);
    }
    else{
        if (isset($_GET["domaine"])){
            header('location: ../Theme.php?domaine='. $_GET["domaine"]);
        }
        else{
                header('location: ../Forum.php');
        }
    }


?>
