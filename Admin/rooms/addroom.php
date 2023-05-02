<?php

session_start();
if(!isset($_SESSION['id'])) {
    header('location: ../login.php');
}
?>

<?php require_once('../../db/db.php') ?>
<?php 

function addRoom($name, $num, $category, $cap, $img) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("INSERT INTO rooms (name, number, category, capacity, image) VALUES (:name, :num, :catg, :cap, :img)" );
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':num', $num);
    $stmt->bindValue(':catg', $category);
    $stmt->bindValue(':cap', $cap);
    $stmt->bindValue(':img', $img);

    $stmt->execute();
}

function getCategories(){
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $num = $_POST['num'];
    $category = $_POST['category'];
    $cap = $_POST['cap']; 

    // handle image upload   
    $valid_ext = ['jpg', 'jpeg', 'png'];
    $file = $_FILES['image'];

    $fileName = $file['name'];
    $fileTmpDes = $file['tmp_name'];
    $fileError = $file['error'];

    $fileExt = explode('.', $fileName);
    $actualFileExt = strtolower(end($fileExt));

    $fileNewName = uniqid('', true) . '.' . $actualFileExt;
    $destination = "../../img/" . $fileNewName;
    $poster = $destination;
    move_uploaded_file($fileTmpDes, $destination); 

    $file_url = "/img/" . $fileNewName;

    // add to database
    addRoom($name, $num, $category, $cap, $file_url);

    // header('Location: ./dashboard.php');
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
        <form class="add-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Room name</label>
                <input type="text" class="form-control" name="name" aria-describedby="emailHelp">
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category</label>
                        <?php $catgs = getCategories() ?>
                        <select class="form-control" name="category" id="">
                            <?php foreach ($catgs as $key => $catg) { ?>
                                <option value=<?php echo $catg["id"] ?> ><?php echo $catg["description"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Room number</label>
                        <input type="text" class="form-control" name="num" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Capacity</label>
                <input type="number" class="form-control" name="cap" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Room picture</label>
                <input type="file" class="form-control-file" name="image">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add room</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>