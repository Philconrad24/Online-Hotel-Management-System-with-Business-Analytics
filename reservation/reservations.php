<?php 
   session_start();
   if(!isset($_SESSION['HM_uid'])) {
      header('Location: ./login.php');
   }
?>

<?php require_once('../db/db.php') ?>
<?php

function getRes($id){
    $pdo = establishCONN();
    $stmt = $pdo->prepare("SELECT applications.id, applications.created_by, applications.suite, applications.checkin, applications.checkout, applications.adults, applications.children, applications.totalPrice, applications.isApproved, categories.description, categories.price, users.fname, users.lname, rooms.name AS rname FROM applications LEFT JOIN categories ON applications.suite = categories.id LEFT JOIN users ON applications.created_by = users.id LEFT JOIN rooms ON applications.roomSelected = roomid WHERE applications.created_by = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <?php session_start() ?>
   <section id="dashboard">
      <aside class="aside">
         <nav class="side-nav">
            <h3>Dashboard</h3>
            <ul>
               <li class="side-nav-item"><a href="#" class="dash-side-link"><span style="font-size: 2rem;">🏠</span>Home</a></li>
               <li class="side-nav-item"><a href="#" class="dash-side-link"><span style="font-size: 2rem;">🛌</span>Bookings</a></li>
            </ul>
         </nav>
      </aside>
      <main>
         <nav class="dash-nav">
            <div class="dash-nav-right">
               <p>Welcome <a href="#"><?php echo $_SESSION["HM_ufname"] ?></a></p>
               <p><a href="./logout.php" class="btn btn-secondary">Logout</a></p>
            </div>
         </nav>
         <div class="jumbotron">
            <h1>Hello, <?php echo $_SESSION["HM_ufname"] ?></h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta possimus deserunt est blanditiis ipsam accusamus eius nemo perferendis molestiae mollitia?</p>
            <hr>
            <a href="./index.php" class="btn btn-primary">Create reservation</a>
         </div>
         <div id="bookings">
            <?php $res = getRes($_SESSION["HM_uid"]); ?>
            <table class="table custom-table">
               <thead>
                  <tr>
                     <th scope="col">
                        <!-- <label class="control control--checkbox">
                        <input type="checkbox" class="js-check-all">
                        <div class="control__indicator"></div>
                        </label> -->
                     </th>
                     <th scope="col">Suite</th>
                     <th scope="col">Category</th>
                     <th scope="col">Occupants</th>
                     <th scope="col">Stay in period</th>
                     <th scope="col">Price</th>
                     <th scope="col">Status</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($res as $r) {?>
                  <tr scope="row">
                     <th scope="row">
                        <label class="control control--checkbox">
                        <input type="checkbox">
                        <div class="control__indicator"></div>
                        </label>
                     </th>
                     <td><?php echo $r["rname"] ?></td>
                     <td><a href="#"><?php echo $r["description"]; ?></a></td>
                     <td>
                     <?php echo($r["adults"] + $r["children"]); ?> Occupants
                     <small class="d-block"><?php echo $r["adults"]?> Adults, <?php echo $r["children"] ?> Children</small>
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
                     <td><?php if($r["isApproved"]) {echo "Approved";} else {echo "Pending";} ?></td>
                     <td>
                        <form method="post">
                           <button class="btn btn-secondary btn-sm">Delete</button>
                        </form>
                     </td>
                  </tr>
                  <tr class="spacer"><td colspan="100"></td></tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </main>
   </section>
</body>
</html>