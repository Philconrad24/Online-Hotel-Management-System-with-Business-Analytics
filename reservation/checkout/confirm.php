<?php
   require "./getAccessToken.php";
   require_once("../../db/db.php");

   function changePaymentStatus($apl_id) {
      $pdo = establishCONN();

      $stmt = $pdo->prepare("UPDATE applications SET paymentStatus = :status WHERE applications.id = :id");
      $stmt->bindValue(':status', true);
      $stmt->bindValue(':id', $apl_id);

      $stmt->execute();
   }

   session_start();
   if(isset($_SESSION["HM_MPESA_REQ_ID"])) {
      $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query');
      $curl_post_data = array(
            //Fill in the request parameters with valid values
            "BusinessShortCode"=> 174379,
            "Password"=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjMwMzMxMDgzMjAy",
            "Timestamp"=> "20230331083202",
            "CheckoutRequestID"=> $_SESSION["HM_MPESA_REQ_ID"]
      );

      $data_entry = json_encode($curl_post_data);

      curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $access_token,
            'Content-Type: application/json'
      ]);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_entry);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;

      unset($_SESSION["HM_MPESA_REQ_ID"]);
      //$_SESSION["HM_MPESA_REQ_ID"] = $response;

      $is_paid = json_decode($response)->ResponseDescription === "The service request has been accepted successsfully";
      if($is_paid) {
         $id = $_SESSION['HM_uid'];
         $price = $_GET["payable"];
         $fname = $_SESSION['HM_ufname'];
         $lname = $_SESSION['HM_ulname'];
         $email = $_SESSION['HM_uemail'];
         $roomno = $_GET["roomno"];
         $applId = $_GET["apl_id"];

         changePaymentStatus($applId);
         

         header('location: ../../mail/mail.php?type=ticket&uid='.$id.'&addr='.$email.'&name='.$fname.' '.$lname.'&price='.$price.'&roomno='.$roomno.'&applId='.$applId);
      }
      //echo $response;
      //"ResponseDescription":"The service request has been accepted successsfully"
   }