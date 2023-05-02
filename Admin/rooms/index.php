<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ../login.php');
}

?>
<?php require_once('../../db/db.php') ?>

<?php

    include_once("../reports.php");

    function getRooms() {
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT rooms.roomid, rooms.name, rooms.number, rooms.capacity, rooms.isBooked, categories.description from rooms LEFT JOIN categories ON rooms.category = categories.id");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        genReport(getRooms(), "rooms");
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
                    <a class="nav-link" href="./index.php">Rooms <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../bookings/" class="active">Check in guest</a>
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
    <div class="container">
        <div style="display: flex; gap: .4rem; align-items: center;">
            <a href="../rooms/addroom.php" class="btn btn-primary my-5">Create new room</a>
            <form method="POST">
                <button type="submit" class="btn btn-success">Generate report</button>
            </form>

        </div>
        <table class="table custom-table">
           <thead>
              <tr>
                 <th scope="col">
                    <!-- <label class="control control--checkbox">
                    <input type="checkbox" class="js-check-all">
                    <div class="control__indicator"></div>
                    </label> -->
                 </th>
                 <th scope="col">Room number</th>
                 <th scope="col">Room name</th>
                 <th scope="col">Category</th>
                 <th scope="col">Capacity</th>
                 <th scope="col">Booking status</th>
                 <th scope="col">Action</th>
              </tr>
           </thead>
           <tbody>
              <?php foreach($res = getRooms() as $r) {?>
              <tr scope="row">
                 <th scope="row">
                    <label class="control control--checkbox">
                    <input type="checkbox">
                    <div class="control__indicator"></div>
                    </label>
                 </th>
                 <td><?php echo $r["number"] ?></td>
                 <td><a href="#"><?php echo $r["name"]; ?></a></td>
                 <td>
                  <?php echo($r["description"]); ?> 
                 </td>
                 <td>
                    <?php echo $r["capacity"]; ?> 
                 </td>
                 <td><?php if($r["isBooked"]){echo "Booked";} else { echo "Available";} ?></td>
                 <td>
                  <div class="row">
                     <a href="./update.php?r_id=<?php echo $r["roomid"] ?>" class="btn btn-primary btn-sm mr-3">Update</a>
                     <form action="./delete.php?r_id=<?php echo $r["roomid"] ?>" method="POST">
                        <button class="btn btn-secondary btn-sm">Delete</button>
                     </form>
                  </td>
                  </div>
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