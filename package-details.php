<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['submit2'])) {
    $pid = intval($_GET['pkgid']);
    $useremail = $_SESSION['login'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $comment = $_POST['comment'];
    $status = 0;

    // Insert booking details into the database
    $sql = "INSERT INTO tblbooking(PackageId, UserEmail, FromDate, ToDate, Comment, status) VALUES(:pid, :useremail, :fromdate, :todate, :comment, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Booked Successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>TMS | Package Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script>
        new WOW().init();
        $(function() {
            $("#datepicker, #datepicker1").datepicker();
        });
    </script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="banner-3">
        <div class="container">
            <h1 class="wow zoomIn animated" data-wow-delay=".5s">AGRO Tourism Packages</h1>
        </div>
    </div>
    <div class="selectroom">
        <div class="container">
            <?php if ($error) { ?>
                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
            <?php } else if ($msg) { ?>
                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
            <?php } ?>
            <?php
            $pid = intval($_GET['pkgid']);
            $sql = "SELECT * FROM tbltourpackages WHERE PackageId=:pid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':pid', $pid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <form action="https://uat.esewa.com.np/epay/main" method="post">
                        <div class="selectroom_top">
                            <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                                <img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage); ?>" class="img-responsive" alt="">
                            </div>
                            <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                                <h2><?php echo htmlentities($result->PackageName); ?></h2>
                                <p class="dow">#PKG-<?php echo htmlentities($result->PackageId); ?></p>
                                <p><b>Package Type :</b> <?php echo htmlentities($result->PackageType); ?></p>
                                <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                                <p><b>Features</b> <?php echo htmlentities($result->PackageFetures); ?></p>
                                <div class="ban-bottom">
                                    <div class="bnr-right">
                                        <label class="inputLabel">From</label>
                                        <input class="date" id="datepicker" type="text" placeholder="dd-mm-yyyy" name="fromdate" required="">
                                    </div>
                                    <div class="bnr-right">
                                        <label class="inputLabel">To</label>
                                        <input class="date" id="datepicker1" type="text" placeholder="dd-mm-yyyy" name="todate" required="">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="grand">
                                    <p>Grand Total</p>
                                    <h3>RS.800</h3>
                                </div>
                            </div>
                            <h3>Package Details</h3>
                            <p style="padding-top: 1%"><?php echo htmlentities($result->PackageDetails); ?></p>
                            <div class="clearfix"></div>
                        </div>
                        <!-- Hidden fields for eSewa payment -->
                        <input value="800" name="tAmt" type="hidden"> <!-- Total Amount -->
                        <input value="800" name="amt" type="hidden"> <!-- Actual Amount -->
                        <input value="0" name="txAmt" type="hidden"> <!-- Tax Amount -->
                        <input value="0" name="psc" type="hidden"> <!-- Service Charge -->
                        <input value="0" name="pdc" type="hidden"> <!-- Delivery Charge -->
                        <input value="epay_payment" name="scd" type="hidden"> <!-- eSewa Merchant Code -->
                        <input value="<?php echo htmlentities($result->ProductId); ?>" name="pid" type="hidden"> <!-- Product ID -->
                        <input value="http://yourwebsite.com/success.php?q=su" type="hidden" name="su"> <!-- Success URL -->
                        <input value="http://yourwebsite.com/cancel.php?q=fu" type="hidden" name="fu"> <!-- Failure/Cancel URL -->
                        <div class="selectroom_top">
                            <h2>Travels</h2>
                            <div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms">
                                <ul>
                                    <li class="spe">
                                        <label class="inputLabel">Comment</label>
                                        <input class="special" type="text" name="comment" required="">
                                    </li>
                                    <?php if ($_SESSION['login']) { ?>
                                        <li class="spe" align="center">
                                            <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                        </li>
                                    <?php } else { ?>
                                        <li class="sigi" align="center" style="margin-top: 1%">
                                            <!-- <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn">Book</a> -->
                                            <iframe width="400" height="300" name="iframe_a" style="border:0; z-index:2;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            <a href="https://www.google.com/maps/embed?pb=!4v1684300142198!6m8!1m7!1s-H9VfAkFdMvDUmWKlyxcXg!2m2!1d31.31310487727758!2d75.49535739236562!3f156.94605263157894!4f-0.9473684210526301!5f0.4000000000000002" target="iframe_a" class="btn-primary btn">Book</a>
                                        </li>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                    </form>
                <?php }
            } ?>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <?php include('includes/signup.php'); ?>
    <?php include('includes/signin.php'); ?>
    <?php include('includes/write-us.php'); ?>
</body>
</html>
