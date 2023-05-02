<?php
require_once("../db/db.php");

function verifyUser($id) {
   $pdo = establishCONN();

   $stmt = $pdo->prepare("UPDATE users SET users.is_verified = :state WHERE users.id = :id");
   $stmt->bindValue(':state', true);
   $stmt->bindValue(':id', $id);

   $stmt->execute();
   return true;
}

if($_SERVER["REQUEST_METHOD"] =="GET") {
   $uid = $_GET['uid'];
   if(verifyUser($uid)) {

      $_SESSION['HM_ver_status'] = true;
      header('location: ./dashboard.php');

   } else {
      echo "An error occured. Try again later.";
   }
}
