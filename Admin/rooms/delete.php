<?php require_once('../../db/db.php') ?>

<?php

   function updateroom($id) {

      $pdo = establishCONN(); 
      $stmt = $pdo->prepare("DELETE FROM rooms WHERE roomid = :id;");
      $stmt->bindValue(':id', $id);
      $stmt->execute();
   }

   if($_SERVER["REQUEST_METHOD"] === "POST") {
      $room_id = $_GET['r_id'];
      updateroom($room_id);

      header('Location: ./index.php');
   } 
?>