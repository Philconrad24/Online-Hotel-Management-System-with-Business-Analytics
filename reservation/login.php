<?php require_once('../db/db.php') ?>
<?php
function login($email, $password) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM users  WHERE email LIKE :email");
    $stmt->bindValue(':email', $email);

    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$res) {
        return false;
    } else {
        return [
            'isLogged' => password_verify($password, $res['password']),
            'userObject' => $res
        ];
    }
}

$email = "";
$pwd = "";

$errors = array(
   'pwd' => ''
);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $loged = login($email, $pwd);
    if($loged) {
        if($loged['isLogged']) {
            session_start();
            $_SESSION['HM_uid'] = $loged['userObject']['id'];
            $_SESSION['HM_uemail'] = $loged['userObject']['email'];
            $_SESSION['HM_ufname'] = $loged['userObject']['fname'];
            $_SESSION['HM_ulname'] = $loged['userObject']['lname'];
            $_SESSION['HM_ver_status'] = $loged['userObject']['is_verified'];

            $id = $_SESSION["HM_uid"];

            if(isset($_SESSION["HM_next"])) {
                header('Location: '.$_SESSION["HM_next"]);
            } else {
                header('Location: dashboard.php?uid='.$id);
            }
        } else {
            $errors['pwd'] = 'Invalid Log in. Check email/password';
        }  
    } else {
        $errors['pwd'] = 'Invalid Log in. Check email/password';
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
    <div class="form-container-det" id="login">
        <form class="add-form" method="POST" enctype="multipart/form-data" style="max-width: 468px; margin: 0 auto;">
                <h3 style="text-align: center">Login</h3>
                <div class="form-group">
                    <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" required class="form-control" name="email" aria-describedby="emailHelp" value="<?php echo $email ?>" placeholder="email@domain.com">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" required class="form-control" name="pwd" value="<?php echo $pwd ?>" aria-describedby="emailHelp">
                </div>                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <small>Dont have an account? <a href="./register.php">Sign up</a></small> |
                <small><a href="./reset/request.php">Forgot Password</a></small>
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>