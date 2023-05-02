<?php

require "./getAccessToken.php";

$ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "ShortCode"=> 174379,
    "ResponseType"=> "Completed",
    "ConfirmationURL"=> "https://0f65-41-80-114-231.in.ngrok.io/Hotel-Management-System/Final_Project_part1/reservation/checkout/callback.php",
    "ValidationURL"=> "https://0f65-41-80-114-231.in.ngrok.io/Hotel-Management-System/Final_Project_part1/reservation/checkout/callback.php",
  ]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response     = curl_exec($ch);
curl_close($ch);
echo $response;