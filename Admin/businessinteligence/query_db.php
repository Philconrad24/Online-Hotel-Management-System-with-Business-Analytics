<?php
require_once("../../db/db.php");

function query_db() {
   $pdo = establishCONN();

   $sql = "
   SELECT applications.id as applicationid, users.fname as firstname, users.lname as lastname, applications.checkin, applications.checkout, applications.adults, applications.children, applications.created_on, categories.description as suite, rooms.name as roomname, rooms.number as roomnumber, applications.totalPrice as cost, applications.isApproved as approvalstatus, applications.paymentStatus as paymentstatus FROM `applications` LEFT JOIN users ON applications.created_by = users.id LEFT JOIN categories ON applications.suite = categories.id LEFT JOIN rooms ON applications.roomSelected = rooms.roomid GROUP BY applications.id;
   ";
   $stmt = $pdo->prepare($sql);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($_SERVER["REQUEST_METHOD"] === "GET") {
   $res = json_encode(query_db());
   echo($res);
}