<?php require_once('../db/db.php') ?>

<?php
    function getMonths() {
        $pdo = establishCONN(); 
        $stmt = $pdo->prepare("SELECT checkout FROM applications GROUP BY MONTH(`checkout`)");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getApls($num, $suite) {
        $pdo = establishCONN(); 
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM applications WHERE MONTH(`checkout`) = :num  AND suite = :suite");
        $stmt->bindValue(':num', $num);
        $stmt->bindValue(':suite', $suite);

        $res = $stmt->execute();
        // var_dump($res);
        // $stmt->fetch(PDO::FETCH_ASSOC);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getEarnings($num) {
        $pdo = establishCONN(); 
        $stmt = $pdo->prepare("SELECT SUM(totalPrice) AS total FROM applications WHERE MONTH(`checkout`) = :num");
        $stmt->bindValue(':num', $num);

        $res = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function generateDataset() {
        $dataset = array(
            "bookings" => array(),
            "earnings" => array()
        );

        $suites = [5, 6, 7];
        $months = getMonths();

        foreach($suites as $suite) {
            foreach($months as $month) {
                $m = explode("-", $month["checkout"])[1];
                $name = "";

                if($suite === 5){ $name = "Luxury suite";}
                if($suite === 6){ $name = "Family suite";}
                if($suite === 7){ $name = "Premium suite";}

                $date = DateTime::createFromFormat('!m', $m);
                $month_string = $date->format('F');

                $count = getApls((int)$m, $suite);
                $dataset["bookings"][$name][$month_string] = $count["count"];
            }
        }

        foreach($months as $month) {
            $m = explode("-", $month["checkout"])[1];

            $date = DateTime::createFromFormat('!m', $m);
            $month_string = $date->format('F');

            $total = getEarnings((int)$m,);
            $dataset["earnings"][$month_string] = (int)$total["total"];
        }
        
        return $dataset;
    }

    if($_SERVER["REQUEST_METHOD"] == "GET") {

      echo json_encode( generateDataset());
    }
?>