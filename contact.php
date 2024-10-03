<?php
// Start session and include config
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/header.php');
// Initialize message variables
$msg = "";
$error = "";

// Check if form is submitted
if(isset($_POST['submit1'])) {
    // Trim and sanitize input data
    $fname = trim(filter_var($_POST['fname'], FILTER_SANITIZE_STRING)); 
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $mobile = trim($_POST['mobileno']);
    $subject = trim(filter_var($_POST['subject'], FILTER_SANITIZE_STRING));
    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
    
    // Initialize an array to store error messages
    $errors = [];

    // Full Name Validation
    if(empty($fname) || !preg_match("/^[a-zA-Z ]*$/", $fname)) {
        $errors[] = "Please enter a valid name (letters and spaces only).";
    }

    // Email Validation
   // Email Validation
if(empty($email) || !preg_match("/^[^\d][a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
    $errors[] = "Please enter a valid email address that must end with '@gmail.com'.";
}

    // Mobile Number Validation
    if(empty($mobile) || !preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors[] = "Please enter a valid 10-digit mobile number.";
    }

    // Subject Validation
    if(empty($subject) || !preg_match("/^[a-zA-Z]*$/", $subject)) {
        $errors[] = "Please enter a valid subject (letters and spaces only).";
    }

    // Description Validation
    if(empty($description) || strlen($description) < 10) {
        $errors[] = "Description must be at least 10 characters long.";
    }

    // If no validation errors, proceed with database insertion
    if(empty($errors)) {
        $sql = "INSERT INTO tblenquiry (FullName, EmailId, MobileNumber, Subject, Description) VALUES (:fname, :email, :mobile, :subject, :description)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':subject', $subject, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->execute();
        
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $msg = "Enquiry Successfully submitted";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    } else {
        // If there are validation errors, show the error messages
        foreach ($errors as $err) {
            $error .= "<div class='errorWrap'>$err</div>";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Enquiry Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Submit Your Enquiry</h1>
        
        <!-- Display success or error message -->
        <?php if($msg){ ?>
            <div class="succWrap"><?php echo $msg; ?></div>
        <?php } elseif($error){ ?>
            <?php echo $error; ?>
        <?php } ?>

        <!-- Form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="fname">Full Name</label>
                <input type="text" class="form-control" name="fname" placeholder="Full Name" required pattern="[A-Za-z ]+">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="mobileno">Mobile Number</label>
                <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number" required pattern="[0-9]{10}">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" placeholder="Description" required minlength="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit1">Submit</button>
        </form>
    </div>
	<?php
	include('includes/footer.php');
	?>
</body>
</html>
