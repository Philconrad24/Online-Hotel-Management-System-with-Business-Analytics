<?php require_once('../db/db.php') ?>
<?php

function addUser($fname, $lname, $id, $email, $mobile, $pwd) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("INSERT INTO users (fname, lname, idNumber, email, mobile, password) VALUES (:fname, :lname, :id, :email, :mobile, :pwd)" );
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':mobile', $mobile);
    $stmt->bindValue(':pwd', $pwd);

    $stmt->execute();
}

// error checking
$fname = "";
$lname = "";
$dnum = "";
$email = "";
$mobile = "";
$pwd = "";
$cpwd = "";

$errors = [
   'fname' => "",
   'lname' => "",
   'email' => "",
   'dnum' => "",
   'mobile' => "",
   'pwd' => "",
   'pwd1' => ""
];



if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dnum = $_POST['dnum'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $pwd = $_POST['pwd'];
    $cpwd = $_POST["cpwd"];

    // handle user input errors
   if(!preg_match("/^[a-z ,.'-]+$/i", $fname)){
      $errors['fname'] = "Invalid name entry";
   }
   if(!preg_match("/^[a-z ,.'-]+$/i", $lname)){
      $errors['lname'] = "Invalid name entry";
   }
   if(!preg_match("/^\d+$/", $dnum)){
      $errors['dnum'] = "Invalid Identification entry";
   }
   if(!preg_match("/^07\d{8}$/", $mobile)){
      $errors['mobile'] = "Invalid mobile number";
   }
   if(!preg_match("/^[a-zA-Z0-9._%+-]+@(gmail|hotmail|yahoo)\.com$/", $email)){
      $errors['email'] = "Invalid Email entry";
   }
   if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $pwd)) {
         $errors['pwd'] = "Password must contain 8 or characters, capital letters and special characters";
   }
   if($cpwd !== $pwd) {
         $errors['pwd1'] = "Passwords do not match";
   }

   function getID($email) {
      $pdo = establishCONN();
      $stmt = $pdo->prepare("SELECT users.id from users WHERE users.email = :email");
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      $id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
      return $id;
   }
   
   if(!array_filter($errors)) {
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        addUser($fname, $lname, $dnum, $email, $mobile, $pwd);
        $id = getID($email);

        header('location: ../mail/mail.php?type=verification&uid='.$id.'&addr='.$email.'&name='.$fname.''.$lname);
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
    <link rel="stylesheet" href="style.css">

    <title>register</title>
  </head>
  <body>
    <div class="form-container-det">
        <form class="add-form" method="POST" enctype="multipart/form-data" style="max-width: 648px; margin: 0 auto;"> 
            <h3 style="text-align: center">Create an account</h3>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">First name</label>
                        <input type="text" required class="form-control" name="fname" aria-describedby="emailHelp" placeholder="John" value="<?php echo $fname ?>">
                        <small style="color: red;"><?php echo $errors['fname'] ?></small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last name</label>
                        <input type="text" required class="form-control" name="lname" aria-describedby="emailHelp" value="<?php echo $lname ?>" placeholder="Doe">
                        <small style="color: red;"><?php echo $errors['lname'] ?></small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">ID/Passport number</label>
                <input type="text" required class="form-control" name="dnum" aria-describedby="emailHelp" value="<?php echo $dnum ?>" placeholder="document number">
                <small style="color: red;"><?php echo $errors['dnum'] ?></small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" required class="form-control" name="email" aria-describedby="emailHelp" value="<?php echo $email ?>" placeholder="email@domain.com">
                <small style="color: red;"><?php echo $errors['email'] ?></small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Mobile no.</label>
                <input type="tel" required class="form-control" name="mobile" aria-describedby="emailHelp" value="<?php echo $mobile ?>" placeholder="07xxxxxxxx">
                <small style="color: red;"><?php echo $errors['mobile'] ?></small>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input required type="password" class="form-control" name="pwd" value="<?php echo $pwd ?>" aria-describedby="emailHelp">
                        <small style="color: red;"><?php echo $errors['pwd'] ?></small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm password</label>
                        <input required type="password" class="form-control" name="cpwd" value="<?php echo $cpwd ?>" aria-describedby="emailHelp">
                        <small style="color: red;"><?php echo $errors['pwd1'] ?></small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            <small>Already have an account? <a href="./login.php">Login</a></small>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>