<?php require_once('../../db/db.php') ?>

<?php

   function updateApplication($id) {

      $pdo = establishCONN(); 
      $stmt = $pdo->prepare("UPDATE applications SET isApproved = :state WHERE id = :id");
      $stmt->bindValue(':state', true);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
   }

   if($_SERVER["REQUEST_METHOD"] === "POST") {
      $application_id = $_GET['apl_id'];
      updateApplication($application_id);

      header('Location: ./index.php');
   } 
?>