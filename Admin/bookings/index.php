<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ../login.php');
}

?>
<?php require_once('../../db/db.php') ?>

<?php
include_once("../reports.php");
   function checKRef($ref) {
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT booking_id FROM bookings WHERE bookings.`reference_number` = :ref" );
        $stmt->bindValue(':ref', $ref);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$res) {
         return false;
        }

        return $res["booking_id"];
    }

    function updateBooking($ref) {
      if(!checKRef($ref)) {
         return false;
      }
      $pdo = establishCONN();

      $stmt = $pdo->prepare("UPDATE bookings SET bookings.is_verified = :state WHERE bookings.reference_number = :ref");
      $stmt->bindValue(':state', true);
      $stmt->bindValue(':ref', $ref);
      
      $stmt->execute();
      return true;
    }

    function getApproved(){
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT applications.id, applications.created_by, applications.suite, applications.checkin, applications.checkout, applications.adults, applications.children, applications.totalPrice, applications.roomSelected, applications.isApproved, applications.paymentStatus, categories.description, categories.price, users.fname, users.lname FROM applications LEFT JOIN categories ON applications.suite = categories.id LEFT JOIN users ON applications.created_by = users.id WHERE applications.isApproved = :state");
        $stmt->bindValue(':state', true);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $response_text = "";
    $is_positive = false;
    $ref_no = "";

   if($_SERVER["REQUEST_METHOD"] === "POST") {
      $ref_no = ucfirst($_POST["refno"]);
         
      $res = updateBooking($ref_no);
        
      if(!$res) {
         $response_text ="Ticket Reference Invalid.";
      } else {
         $response_text = "Ticket Validated successfully.";
         $is_positive = true;
         $ref_no = "";
      }
   }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <title>Reservation</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                     <a class="nav-link" href="../rooms/">Rooms <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="./index.php" class="active">Check in guest</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../reservations/" class="active">Reservations</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../businessinteligence/" class="active">Business inteligence</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../logout.php">Log out</a>
                  </li>
               </ul>
            </div>
        </div>
    </nav>
    <div class="container my-4">
      <h3>CHeck in guests</h3><hr>
      <form  method="POST" class="mb-4" style="width: 60%;">
         <?php if($response_text) { ?>
            <?php if($is_positive){  ?>
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Verification successful.</strong> <?php echo $response_text ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            <?php } else { ?>
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Verification unsuccessful.</strong> <?php echo $response_text ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            <?php } ?>
         <?php } ?>
         <div class="input-group">
           <input type="text" required class="form-control" placeholder="Enter reference number" name="refno" value=<?php echo $ref_no ?>>
           <div class="input-group-append">
             <button type="submit" class="btn btn-primary">Checkin guest</button>
           </div>
         </div>
      </form>
        <table class="table custom-table my-3">
           <thead>
              <tr>
                 <th scope="col">Room</th>
                 <th scope="col">Customer name</th>
                 <th scope="col">Checkin</th>
                 <th scope="col">Checkout</th>
                 <th scope="col">Price</th>
              </tr>
           </thead>
           <tbody>
              <?php foreach($res = getApproved() as $r) {?>
              <tr scope="row">
                 <td><?php echo $r["roomSelected"] ?></td>
                 <td><a href="#"><?php echo $r["fname"] . " " . $r["lname"]; ?></a></td>
                 <td>
                    <?php echo($r["checkin"]); ?>
                 </td>
                 <td>
                    <?php echo($r["checkout"]); ?>
                 </td>
                 <td style="font-weight: bolder;"><?php echo $r["totalPrice"] ?></td>
              </tr>
              <tr class="spacer"><td colspan="100"></td></tr>
              <?php } ?>
           </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>