<?php
  //la page d'orientation
  session_start();
  if (isset($_SESSION["type"]) && (strcmp($_SESSION["type"],"a")==0)){
    header("location: ./moderateur/forum.php");
  }
  else{
    header("location: ./Accueil.php");
  }
?>
