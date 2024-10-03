<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else { 
    // Check for delete action
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $sql = "DELETE FROM tblusers WHERE id = :id"; // Make sure 'id' is the correct column name
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        echo "<script>alert('User deleted successfully');</script>";
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin manage Users</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> 
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
    function hideURLbar(){ window.scrollTo(0,1); } 
</script>
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
<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').basictable();
        // other table options
    });
</script>
<!-- //tables -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
</head> 
<body>
   <div class="page-container">
   <div class="left-content">
       <div class="mother-grid-inner">
           <?php include('includes/header.php');?>
           <div class="clearfix"></div>	
       </div>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Users</li>
</ol>
<div class="agile-grids">	
    <div class="agile-tables">
        <div class="w3l-table-info">
            <h2>Manage Users</h2>
            <table id="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile No.</th>
                        <th>Email Id</th>
                        <th>RegDate</th>
                        <th>Updation Date</th>
                        <th>Action</th> <!-- Added Action Column -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT * FROM tblusers";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>		
                            <tr>
                                <td><?php echo htmlentities($cnt); ?></td>
                                <td><?php echo htmlentities($result->FullName); ?></td>
                                <td><?php echo htmlentities($result->MobileNumber); ?></td>
                                <td><?php echo htmlentities($result->EmailId); ?></td>
                                <td><?php echo htmlentities($result->RegDate); ?></td>
                                <td><?php echo htmlentities($result->UpdationDate); ?></td>
                                <td>
                                    <a href="manage-users.php?delete=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <button type="button" class="btn btn-danger btn-block">Delete</button>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                            $cnt = $cnt + 1; 
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Other code remains unchanged -->
<?php include('includes/footer.php');?>
</div>
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
