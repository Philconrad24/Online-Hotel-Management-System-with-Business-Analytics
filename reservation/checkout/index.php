
<?php

    require "./getAccessToken.php";

    if(isset($_SERVER["REQUEST_METHOD"])){
        $phone = $_POST["phone"];
        $amount = 1;

        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            "BusinessShortCode"=> 174379,
            "Password"=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjIwMTI1MTUwOTI0",
            "Timestamp"=> "20220125150924",
            "TransactionType"=> "CustomerPayBillOnline",
            "Amount"=> $amount,
            "PartyA"=> $phone,
            "PartyB"=> 174379,
            "PhoneNumber"=> $phone,
            "CallBackURL"=> "https://0f65-41-80-114-231.in.ngrok.io/Hotel-Management-System/Final_Project_part1/reservation/checkout/callback.php",
            "AccountReference"=> "MIRTH BOOKING",
            "TransactionDesc"=> "Reservation" 
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

        session_start();

        $_SESSION['flash_message'] = "Request sent";
        $_SESSION['HM_MPESA_REQ_ID'] = json_decode($response)->CheckoutRequestID;
        header("Location: ../dashboard.php"); 
    }
?>