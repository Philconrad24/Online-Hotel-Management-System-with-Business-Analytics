<?php require_once('../../db/db.php') ?>
<?php
session_start();
if(!isset($_SESSION['HM_uid'])) {
   header('Location: ./login.php');
}

function checkEmail($email) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM users  WHERE email LIKE :email");
    $stmt->bindValue(':email', $email);

    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$res) {
        return false;
    } else {
        return $res;
    }
}
function updatePassword($id, $pass) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("UPDATE users SET users.password = :pass WHERE users.id = :id");
    $stmt->bindValue(':pass', $pass);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
}

$pwd = "";

$errors = array(
   'pwd' => ''
);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = $_SESSION['HM_uemail'];
   $old_pwd = $_POST['oldpwd'];
   $new_pwd = $_POST['newpwd'];

   $user_obj = checkEmail($email);
   if(!$user_obj) {
      $errors["pwd"] = "Email not found.";
   } elseif(password_verify($old_pwd, $user_obj["password"])) {

      $save_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
      $id = $user_obj["id"];

      updatePassword($id, $save_pwd);
      header('location: ../login.php');
   } else {
      $errors["pwd"] = "Password not found.";
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

    <title>login</title>
  </head>
  <body>
        <form class="add-form" method="POST" style="max-width: 468px; margin: 0 auto;">
            <h3 style="text-align: center">Change password</h3>
            <hr>
            <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
            <div class="form-group">
                <label for="exampleInputEmail1">Old Password</label>
                <input type="password" required class="form-control" name="oldpwd" value="<?php echo $pwd ?>" aria-describedby="emailHelp">
            </div>                
            <div class="form-group">
                <label for="exampleInputEmail1">New Password</label>
                <input type="password" required class="form-control" name="newpwd" value="<?php echo $pwd ?>" aria-describedby="emailHelp">
            </div>                
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>