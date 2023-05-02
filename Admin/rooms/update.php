<?php

session_start();
if(!isset($_SESSION['id'])) {
    header('location: ../login.php');
}
?>

<?php require_once('../../db/db.php') ?>
<?php 

function getCategories(){
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateRoom($name,$num, $category, $cap, $id) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("UPDATE rooms SET name = :name, number = :num, category = :catg, capacity = :cap WHERE roomid = :id" );
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':num', $num);
    $stmt->bindValue(':catg', $category);
    $stmt->bindValue(':cap', $cap);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
}

function getRoom($id){
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE roomid = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $num = $_POST['num'];
    $category = $_POST['category'];
    $cap = $_POST['cap']; 

    // add to database
    updateRoom($num, $category, $cap, $_GET["r_id"]);

    header('Location: ./index.php');
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
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Rooms <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./reservations.php">Reservations</a>
                </li>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php $room = getRoom($_GET["r_id"]); ?>
        <form class="add-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Room name</label>
                <input type="text" class="form-control" name="name" aria-describedby="emailHelp" value="<?php echo $room["name"] ?>">
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
                        <input type="text" class="form-control" name="num" aria-describedby="emailHelp" value="<?php echo $room["number"] ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Capacity</label>
                <input type="number" class="form-control" name="cap" aria-describedby="emailHelp" min=1 value="<?php echo $room["capacity"] ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update room</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>