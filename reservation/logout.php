<?php 
   session_start();
   if(!isset($_SESSION['HM_uid'])) {
      header('Location: ./login.php');
   }
?>

<?php

session_start();
session_destroy();

header('Location: ./login.php');
?>