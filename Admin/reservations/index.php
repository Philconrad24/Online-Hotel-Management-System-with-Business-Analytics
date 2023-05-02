<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ../login.php');
}

?>
<?php require_once('../../db/db.php') ?>

<?php

    function getRooms($category, $capacity) {
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT id, number from rooms WHERE isBooked = :state AND category = :ct AND capacity >= :cpt");
        $stmt->bindValue(':state', false);
        $stmt->bindValue(':ct', $category);
        $stmt->bindValue(':cpt', $capacity);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    function getRes(){
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT applications.id, applications.created_by, applications.suite, applications.checkin, applications.checkout, applications.adults, applications.children, applications.totalPrice, applications.roomSelected, applications.isApproved, applications.paymentStatus, categories.description, categories.price, users.fname, users.lname FROM applications LEFT JOIN categories ON applications.suite = categories.id LEFT JOIN users ON applications.created_by = users.id WHERE applications.isApproved = :state");
        $stmt->bindValue(':state', false);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <style>
        .section {
            display: none;
        }

        .section.active {
            display: block;
        }
    </style>
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
                    <a class="nav-link" href="../bookings/" class="active">Check in guest</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php" class="active">Reservations</a>
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
        <script>
            /* JavaScript */
            function showSection(sectionId) {
            // Hide all content sections
            var sections = document.getElementsByClassName('section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }

            // Show the selected content section
            document.getElementById(sectionId).classList.add('active');
            }

            // Show Section 1 by default
            document.getElementById('section1').classList.add('active');
        </script>
    </nav>
    <div class="container">
        <a href="./approved.php" class="btn btn-primary my-3">View approved Applications</a>
        <table class="table custom-table my-5">
           <thead>
              <tr>
                 <th scope="col">
                    <!-- <label class="control control--checkbox">
                    <input type="checkbox" class="js-check-all">
                    <div class="control__indicator"></div>
                    </label> -->
                 </th>
                 <th scope="col">Room</th>
                 <th scope="col">Customer name</th>
                 <th scope="col">Occupants</th>
                 <th scope="col">Stay in period</th>
                 <th scope="col">Price</th>
                 <th scope="col">Approval</th>
                 <th scope="col">Payment status</th>
                 <th scope="col">Action</th>
              </tr>
           </thead>
           <tbody>
              <?php foreach($res = getRes() as $r) {?>
              <tr scope="row">
                 <th scope="row">
                    <label class="control control--checkbox">
                    <input type="checkbox">
                    <div class="control__indicator"></div>
                    </label>
                 </th>
                 <td><?php echo $r["roomSelected"] ?></td>
                 <td><a href="#"><?php echo $r["fname"] . " " . $r["lname"]; ?></a></td>
                 <td>
                 <?php echo($r["adults"] + $r["children"]); ?> Occupant(s)
                 <small class="d-block"><?php echo $r["adults"]?> Adult(s), <?php echo $r["children"] ?> Children</small>
                 </td>
                 <td>
                    <?php 
                       $date1 = new DateTime($r["checkin"]);
                       $date2 = new DateTime($r["checkout"]);
                       // this calculates the diff between two dates, which is the number of nights
                       $numberOfNights= $date2->diff($date1)->format("%a");
                       $total = $numberOfNights * $r["price"];
                    ?>
                    <?php echo $numberOfNights ?> Nights
                 </td>
                 <td>Kshs <?php echo $total ?></td>
                 <td><?php if($r["isApproved"]) {echo "Approved";} else {echo "Received";} ?></td>
                 <td style="font-weight: bolder;"><?php if($r["paymentStatus"]) {echo "Paid";} else {echo "Pending";} ?></td>
                 <td>
                    <form action="./approve.php?apl_id=<?php echo $r["id"] ?>" method="POST">
                        <button class="btn btn-primary btn-sm">Approve</button>
                        <button class="btn btn-secondary btn-sm">Delete</button>
                    </form>
                 </td>
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