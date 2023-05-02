<?php require_once('../db/db.php') ?>

<?php 
    $cp = 0;
    if(isset($_GET['cp'])) { 
        $cp = $_GET["cp"];
    } 
?>

<?php
function getCategories(){
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRooms($capacity) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT roomid, rooms.name, rooms.image, categories.description AS category, categories.price FROM rooms LEFT JOIN categories ON rooms.category = categories.id WHERE rooms.isReserved = :state AND rooms.capacity >= :cp");
    $stmt->bindValue(":state", false);
    $stmt->bindValue(":cp", $capacity);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRoomVar($category, $capacity) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT roomid, rooms.name, rooms.image, categories.description AS category, categories.price FROM rooms LEFT JOIN categories ON rooms.category = categories.id WHERE rooms.isBooked = :state AND rooms.category = :ct AND rooms.capacity >= :cp");
    $stmt->bindValue(":state", false);
    $stmt->bindValue(":ct", $category);
    $stmt->bindValue(":cp", $capacity);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $suite = $_POST['suite'];

    $rooms = getRoomVar($suite, (int)$adults + (int)$children);
} else {
    $rooms = getRooms($cp);
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

    <title>Reservation</title>
  </head>
  <body>
    <section class="header">
        <form  method="POST" enctype="multipart/form-data">
        <a href="./dashboard.php" class="mb-4 btn1" style="color: fff; font-weight: bold;"> Go to dashboard</a>
            <div class="form-cont">
                <div class="form-group">
                    <label for="exampleInputEmail1">Category:</label>
                    <?php $catgs = getCategories() ?>
                    <select class="form-control" name="suite" id="">
                        <?php foreach ($catgs as $key => $catg) { ?>
                            <option value=<?php echo $catg["id"] ?> ><?php echo $catg["description"] . " " . "Kshs " . $catg['price'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Checkin date:</label>
                    <input type="date" class="form-control" name="in" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Checkout date:</label>
                    <input type="date" class="form-control" name="out" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Adults:</label>
                    <input type="number" class="form-control" name="adults" aria-describedby="emailHelp" placeholder="number of adults">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Children:</label>
                    <input type="number" class="form-control" name="children" aria-describedby="emailHelp" placeholder="number of children">
                </div>
                <div class="form-group"><button type="submit" class="btn btn-secondary">Search room</button></div>
            </div> 
        </form>
    </section>
    <section class="rooms">
        <div class="rooms-cont">
            <?php foreach($rooms as $room) {?>
            <div class="room">
                <div class="room-ill">
                    <img src="..<?php echo $room["image"]; ?>" alt="<?php echo $room["name"]; ?> image">
                </div>
                <div class="details">
                    <p class="name"><?php echo $room["name"]; ?></p>
                    <p class="category"><?php echo $room["category"] ?></p>
                </div>
                <div class="price">
                    <p class="price"><?php echo $room["price"] ?> per night.</p>
                </div>
                <a href="./book.php?rid=<?php echo $room["roomid"]; ?>" class="btn btn-block btn-primary">Reserve room</a>
            </div>
            <?php } ?>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>