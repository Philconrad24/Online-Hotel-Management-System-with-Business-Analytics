<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ../login.php');
}

?>

<?php require_once('../../db/db.php') ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <title>Reservation</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
      // Get the data from the PHP file using fetch
      const query_data = async () => {
         try {
            const res = await fetch('../getData.php')
            const data = await res.json()

            return data
         } catch (error) {
            console.error(error)
         }
      }
      query_data().then(data => console.log(data))
      
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         query_data().then(data => {
            data = data.earnings

            const keys = Object.keys(data);
            const values = Object.values(data);

            const result = keys.map((key, index) => [key, values[index]])
            console.log(result)
            var data = google.visualization.arrayToDataTable([
               ['Month', 'Earning'], ...result
            ]);

            var materialOptions = {
               chart: {
                  title: 'MIRTH BOOKING Earning',
                  subtitle: '2022 - 2023 Financial year earning'
               },
               hAxis: {
                  title: 'Monthly earnings'
               }
            };
            var materialChart = new google.charts.Bar(document.getElementById('sales_chart'));
            materialChart.draw(data, materialOptions);
         })
         
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         query_data().then(data => {
            data = data.bookings
            const months = Object.keys(data["Luxury suite"]);
            const luxurySuiteData = ["Luxury suite"];
            const familySuiteData = ["Family suite"];
            const premiumSuiteData = ["Premium suite"];

            months.forEach(month => {
               luxurySuiteData.push(data["Luxury suite"][month]);
               familySuiteData.push(data["Family suite"][month]);
               premiumSuiteData.push(data["Premium suite"][month]);
            });

            // Get an array of all the months
            const mon = Object.keys(data["Luxury suite"]);

            // Create an array of arrays, where each sub-array represents a suite
            const suites = Object.keys(data).map((suiteName) => {
               const suiteData = data[suiteName];
               return [suiteName, ...mon.map((month) => suiteData[month])];
            });
            
            console.log(suites)

            var data = google.visualization.arrayToDataTable([
               ['Suite', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
               suites[0],
               suites[1],
               suites[2]
               
            ]);

            var materialOptions = {
               chart: {
                  title: 'MIRTH BOOKING Reservations',
                  subtitle: 'Number of booking per suite'
               },
               hAxis: {
                  title: 'Reservations'
               },
               vAxis: {
                  title: 'Number of reservations'
               }
            };
            var materialChart = new google.charts.Bar(document.getElementById('curve_chart'));
            materialChart.draw(data, materialOptions);
         })
         
      }
    </script> 
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
                     <a class="nav-link" href="../rooms/">Rooms <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../bookings/" class="active">Check in guest</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../reservations/" class="active">Reservations</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="./index.php" class="active">Business inteligence</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../logout.php">Log out</a>
                  </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="my-5" onload="getDataset()" style="display: flex; gap: 1rem;" >
            <div id="curve_chart" style="width: 800px; border: #000 .7px solid; padding: 16px; height: 500px"></div>
            <div id="sales_chart" style="width: 800px; border: #000 .7px solid; padding: 16px; height: 500px"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>