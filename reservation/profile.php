<?php 
   session_start();
   if(!isset($_SESSION['HM_uid'])) {
      header('Location: ./login.php');
   }
?>

<?php require_once('../db/db.php') ?>
<?php

function updateUser($id, $fname, $lname){
    $pdo = establishCONN();
    $stmt = $pdo->prepare("UPDATE users SET users.fname = :fname, users.lname = :lname WHERE users.id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);

    $stmt->execute();
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
   $fname = $_POST["fname"];
   $lname = $_POST["lname"];
   $id = $_SESSION['HM_uid'];

   updateUser($id, $fname, $lname);
   $_SESSION['HM_ufname'] = $fname;
   $_SESSION['HM_ulname'] = $lname;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mirth booking</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
   <link rel="stylesheet" href="style.css">

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
   <section id="dashboard">
      <aside class="aside">
         <nav class="side-nav">
            <h3>Dashboard</h3>
            <ul>
               <li class="side-nav-item"><a href="./dashboard.php" class="dash-side-link" ><span><- </span>Back</a></li>
            </ul>
         </nav>
      </aside>
      <main>
         <div class="main-content">
            <nav class="dash-nav">
               <div class="dash-nav-right">
                  <p class="textt-lg"><b>Welcome <a href="./profile.php"><?php echo $_SESSION["HM_ufname"] ?></a></b></p>
                  <p><a href="./logout.php" class="btn btn-secondary">Logout</a></p>
               </div>
            </nav>
            <?php if($_SESSION["HM_ver_status"]) {?>
               <form action="" method="POST" style="width: 60%;">
                  <div class="form-top-c">
                     <p>Manage Account</p>
                     <h3><?php echo $_SESSION['HM_ufname'] ?> <?php echo $_SESSION['HM_ulname'] ?></h3>
                     <p>Email: <span style="font-weight: bold;"><?php echo $_SESSION['HM_uemail'] ?></span></p>
                  </div>
                  <div class="form-group">
                     <label for="fname">First Name:</label>
                     <input type="text" class="form-control input-sm" value="<?php echo $_SESSION['HM_ufname'] ?>" name="fname" required>
                  </div>
                  <div class="form-group">
                     <label for="lname">Last Name:</label>
                     <input type="text" class="form-control input-sm" value="<?php echo $_SESSION['HM_ulname'] ?>" name="lname" required>
                  </div>
                  <button type="submit" class="btn btn-outline-primary">Update profile</button><br>
                  <br><a href="./reset/changePassword.php">Change password</a>
               </form>
            <?php } else {?>
               <div class="jumbotron">
                  <h3>Verify email address</h3>
                  <p>Check the email adress you provided to verify the adress.</p>
               </div>
            <?php } ?>
         </div>
      </main>
   </section>
   <script defer>
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
      document.getElementById('jumbotron').classList.add('active');
   </script>
</body>
</html>