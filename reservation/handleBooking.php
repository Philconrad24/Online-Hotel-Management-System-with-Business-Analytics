<?php 
   session_start();
   if(!isset($_SESSION['HM_uid'])) {
      header('Location: ./login.php');
   }
?>

<?php require_once('../db/db.php') ?>
<?php
    function getPrice($id) {
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT price FROM categories WHERE categories.`id` = :id" );
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res[0]["price"];
    }

    function addReq($creator, $checkin, $checkout, $adults, $children, $suite, $rs, $total) {
        $pdo = establishCONN();

        $stmt = $pdo->prepare("INSERT INTO applications (created_by, checkin, checkout, adults, children, suite, roomSelected, totalPrice) VALUES (:creator, :checkin, :checkout, :adults, :children, :suite, :rs, :total)");
        $stmt->bindValue(':creator', $creator);
        $stmt->bindValue(':checkin', $checkin);
        $stmt->bindValue(':checkout', $checkout);
        $stmt->bindValue(':adults', $adults);
        $stmt->bindValue(':children', $children);
        $stmt->bindValue(':suite', $suite);
        $stmt->bindValue(':rs', $rs);
        $stmt->bindValue(':total', $total);

        $stmt->execute();
    }


    session_start();

    $_SESSION["HM_rcheckin"] = $_POST["checkin"];
    $_SESSION["HM_rcheckout"] = $_POST["checkout"];
    $_SESSION["HM_gfname"] = $_POST["fname"];
    $_SESSION["HM_glname"] = $_POST["lname"];
    $_SESSION["HM_gemail"] = $_POST["email"];
    $_SESSION["HM_roomselect"] = $_GET["rid"];

    $date1 = new DateTime($_POST["checkin"]);
    $date2 = new DateTime($_POST["checkout"]);

    // this calculates the diff between two dates, which is the number of nights
    $numberOfNights = $date2->diff($date1)->format("%a");
    $total = $numberOfNights * getPrice($_SESSION["HM_categoryId"]);

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $creator = $_SESSION["HM_uid"];
        $checkin = $_SESSION["HM_rcheckin"];
        $checkout = $_SESSION["HM_rcheckout"];
        $children = (int)$_POST["children"];
        $adults = (int)$_POST["adults"];
        $category = $_SESSION["HM_categoryId"];
        $room = $_SESSION["HM_roomselect"];

        if(!isset($_SESSION['HM_uid'])) {
            header('location: ./login.php');
            $_SESSION["HM_next"] = 'book.php?rid=' . $_SESSION["HM_roomselect"];
        } else {
            addReq($creator, $checkin, $checkout, $adults, $children, $category, $room, $total);
            header('Location: dashboard.php?uid='.$_SESSION["HM_uid"]);
        }
    }

?>