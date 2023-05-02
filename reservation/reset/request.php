<?php require_once('../../db/db.php') ?>
<?php

function checkEmail($email) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM users  WHERE email LIKE :email");
    $stmt->bindValue(':email', $email);

    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$res) {
        return false;
    } else {
        return true;
    }
}

$email = "";

$errors = array(
   'pwd' => ''
);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

   if(!checkEmail($email)) {
      $errors["pwd"] = "Email not found.";
   } else {
      header('location: ../../mail/mail.php?type=reset&addr='.$email);
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

    <title>password reset</title>
  </head>
  <body>
        <form class="add-form" method="POST" style="max-width: 468px; margin: 0 auto;">
            <h3 style="text-align: center">Password reset</h3>
            <hr>
            <div class="form-group">
                <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
                <label for="exampleInputEmail1">Enter your email</label>
                <input type="email" required class="form-control" name="email" aria-describedby="emailHelp" value="<?php echo $email ?>" placeholder="email@domain.com">
            </div>               
            <button type="submit" class="btn btn-primary btn-block">Send Link</button>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>