<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {    
header('location:index.php');
}
else{
?>

<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->

<!-- Custom CSS for Chart Sizing -->
<style>
    .charts-container {
        margin: 20px auto;
        text-align: center;
    }

    /* Fixed width and height for charts */
    .chart-wrapper {
        width: 80%; /* Adjust width to your requirement */
        margin: 0 auto;
        padding: 20px 0;
    }

    canvas {
        max-width: 100%;
        height: 400px; /* Fix the height */
    }
</style>

</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
       <div class="mother-grid-inner">
<!--header start here-->
<?php include('includes/header.php');?>
<!--header end here-->
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a> <i class="fa fa-angle-right"></i></li>
            </ol>

<!--four-grids here-->
        <div class="four-grids">
                    <div class="col-md-3 four-grid">
                        <div class="four-agileits">
                            <div class="icon">
                                <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                            </div>
                            <div class="four-text">
                                <h3>User</h3>

                                <?php 
                                $sql = "SELECT id from tblusers";
                                $query = $dbh -> prepare($sql);
                                $query->execute();
                                $cnt=$query->rowCount();
                                ?>          
                                <h4> <?php echo htmlentities($cnt);?> </h4>       
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 four-grid">
                        <div class="four-agileinfo">
                            <div class="icon">
                                <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
                            </div>
                            <div class="four-text">
                                <h3>Bookings</h3>
                                <?php 
                                $sql1 = "SELECT BookingId from tblbooking";
                                $query1 = $dbh -> prepare($sql1);
                                $query1->execute();
                                $cnt1=$query1->rowCount();
                                ?>
                                <h4><?php echo htmlentities($cnt1);?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 four-grid">
                        <div class="four-w3ls">
                            <div class="icon">
                                <i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
                            </div>
                            <div class="four-text">
                                <h3>Enquiries</h3>
                                <?php 
                                $sql2 = "SELECT id from tblenquiry";
                                $query2= $dbh -> prepare($sql2);
                                $query2->execute();
                                $cnt2=$query2->rowCount();
                                ?>
                                <h4><?php echo htmlentities($cnt2);?></h4>   
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 four-grid">
                        <div class="four-wthree">
                            <div class="icon">
                                <i class="glyphicon glyphicon-briefcase" aria-hidden="true"></i>
                            </div>
                            <div class="four-text">
                                <h3>Total Packages</h3>
                                <?php 
                                $sql3 = "SELECT PackageId from tbltourpackages";
                                $query3= $dbh -> prepare($sql3);
                                $query3->execute();
                                $cnt3=$query3->rowCount();
                                ?>
                                <h4><?php echo htmlentities($cnt3);?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

        <div class="four-grids">
                    <div class="col-md-3 four-grid">
                        <div class="four-w3ls">
                            <div class="icon">
                                <i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
                            </div>
                            <div class="four-text">
                                <h3>Issues Raised</h3>
                                <?php 
                                $sql5 = "SELECT id from tblissues";
                                $query5= $dbh -> prepare($sql5);
                                $query5->execute();
                                $cnt5=$query5->rowCount();
                                ?>
                                <h4><?php echo htmlentities($cnt5);?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
<!--//four-grids here-->

<!-- Chart Section -->
<div class="charts-container">
    <h2>Summary Report</h2>

    <!-- Line Chart for Users and Bookings -->
    <div class="chart-wrapper">
        <canvas id="lineChart"></canvas>
    </div>

    <!-- Pie Chart for Enquiries and Packages -->
    <div class="chart-wrapper">
        <canvas id="pieChart"></canvas>
    </div>

    <!-- Bar Graph for Issues and Total Packages -->
    <div class="chart-wrapper">
        <canvas id="barChart"></canvas>
    </div>
</div>

<script>
// Data passed from PHP
let usersCount = <?php echo $cnt; ?>;
let bookingsCount = <?php echo $cnt1; ?>;
let enquiriesCount = <?php echo $cnt2; ?>;
let packagesCount = <?php echo $cnt3; ?>;
let issuesCount = <?php echo $cnt5; ?>;

// Line Chart for Users and Bookings
var ctxLine = document.getElementById('lineChart').getContext('2d');
var lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: ['Users', 'Bookings'],
        datasets: [{
            label: 'Users vs Bookings',
            data: [usersCount, bookingsCount],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Pie Chart for Enquiries and Packages
var ctxPie = document.getElementById('pieChart').getContext('2d');
var pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: ['Enquiries', 'Packages'],
        datasets: [{
            data: [enquiriesCount, packagesCount],
            backgroundColor: ['#FF6384', '#36A2EB'],
        }]
    },
    options: {
        maintainAspectRatio: false
    }
});

// Bar Chart for Issues and Total Packages
var ctxBar = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: ['Issues Raised', 'Total Packages'],
        datasets: [{
            label: 'Issues vs Packages',
            data: [issuesCount, packagesCount],
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<!-- Footer and Sidebar -->
<div class="inner-block"></div>
<?php include('includes/footer.php');?>
<?php include('includes/sidebarmenu.php');?>

<script>
var toggle = true;
$(".sidebar-icon").click(function() {                
  if (toggle) {
    $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
    $("#menu span").css({"position":"absolute"});
  } else {
    $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
    }, 400);
  }
  toggle = !toggle;
});
</script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
<?php } ?>
