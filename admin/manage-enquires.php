<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else { 
    // code for cancel
    if(isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = 1;

        $sql = "UPDATE tblenquiry SET Status=:status WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Enquiry successfully read";
    }

    // code for delete
    if(isset($_REQUEST['delete'])) {
        $deleteId = intval($_GET['delete']);
        $sql = "DELETE FROM tblenquiry WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $deleteId, PDO::PARAM_STR);
        $query->execute();

        $msg = "Enquiry deleted successfully";
    }
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <title>Admin manage Enquiries</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/morris.css" type="text/css"/>
    <link href="css/font-awesome.css" rel="stylesheet"> 
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/table-style.css" />
    <link rel="stylesheet" type="text/css" href="css/basictable.css" />
    <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').basictable();
            $('#table-breakpoint').basictable({ breakpoint: 768 });
            $('#table-swap-axis').basictable({ swapAxis: true });
            $('#table-force-off').basictable({ forceResponsive: false });
            $('#table-no-resize').basictable({ noResize: true });
            $('#table-two-axis').basictable();
            $('#table-max-height').basictable({ tableWrapper: true });
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
    <div class="page-container">
    <div class="left-content">
        <div class="mother-grid-inner">
            <?php include('includes/header.php');?>
            <div class="clearfix"> </div>	
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Enquiries</li>
        </ol>
        <div class="agile-grids">	
            <?php if($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
            else if($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
            <div class="agile-tables">
                <div class="w3l-table-info">
                    <h2>Manage Enquiries</h2>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Ticket id</th>
                                <th>Name</th>
                                <th>Mobile No./ Email</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Posting date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * from tblenquiry";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            if($query->rowCount() > 0) {
                                foreach($results as $result) { ?>		
                                    <tr>
                                        <td width="120">#TCKT-<?php echo htmlentities($result->id); ?></td>
                                        <td width="50"><?php echo htmlentities($result->FullName); ?></td>
                                        <td width="50"><?php echo htmlentities($result->MobileNumber); ?> /<br />
                                            <?php echo $result->EmailId; ?></td>
                                        <td width="200"><?php echo htmlentities($result->Subject); ?></td>
                                        <td width="400"><?php echo htmlentities($result->Description); ?></td>
                                        <td width="50"><?php echo htmlentities($result->PostingDate); ?></td>
                                        <td>
                                            <?php if($result->Status==1) { ?>
                                                Read 
                                            <?php } else { ?>
                                                <a href="manage-enquires.php?eid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to read?')">Pending</a>
                                            <?php } ?>
                                            |
                                            <a href="manage-enquires.php?delete=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete this enquiry?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php } 
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="inner-block"></div>
        <?php include('includes/footer.php');?>
    </div>
    <?php include('includes/sidebarmenu.php');?>
    <div class="clearfix"></div>		
</div>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<script src="js/bootstrap.min.js"></script>	   

</body>
</html>
<?php } ?>
