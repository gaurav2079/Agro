<?php
// Include configuration and autoload for PHPMailer
include 'includes/config.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
session_start();

// Function to generate a 6-digit OTP
function generate_otp() {
    $otp = '';
    $seed = time() * 98765;
    for ($i = 0; $i < 6; $i++) {
        $otp .= ($seed * ($i + 1)) % 10; 
        $seed += 345; 
    }
    return $otp;
}

// Function to hash the password using a salt
function custom_hash($password) {
    $salt = '123asaaks@#$'; 
    $hashed = '';
    for ($i = 0; $i < strlen($password); $i++) {
        $hashed .= dechex(ord($password[$i]) + ord($salt[$i % strlen($salt)]));
    }
    return $hashed;
}

// Create a PDO instance
try {
    $dbh = new PDO("mysql:host=localhost;dbname=tms", "root", "");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Step 1: Handle email submission and send OTP
if (isset($_POST['EmailId'])) {
    $email = $_POST['EmailId'];
    
    // Query to check if email exists in the database
    $stmt = $dbh->prepare("SELECT * FROM tblusers WHERE EmailId = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Generate OTP and store it in the session
        $otp = generate_otp();
        $_SESSION['otp'] = $otp;
        $_SESSION['EmailId'] = $email;

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();                                       // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                // Enable SMTP authentication
            $mail->Username = 'kandelgk64@gmail.com';             // Replace with your Gmail email
            $mail->Password = 'moqs nibf vrvi pvjm';              // Replace with your Gmail app password
            $mail->SMTPSecure = 'tls';                             // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                     // TCP port to connect to

            // Sender and recipient settings
            $mail->setFrom('noreply@agrotourism.com', 'AgroTourism');
            $mail->addAddress($email);                             // Add a recipient

            // Email content
            $mail->isHTML(true);                                   // Set email format to HTML
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = "Your OTP for password reset is: <strong>$otp</strong>";

            // Send email
            $mail->send();

            // Redirect to OTP verification step
            echo "<script>
                alert('A 6-digit OTP has been sent to your email.');
                window.location.href = 'forgot-password.php?step=verify';
            </script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No account found with that email address.";
    }
}

// Step 2: Handle OTP verification
if (isset($_POST['otp_verify'])) {
    $otp_input = $_POST['otp'];
    
    if ($_SESSION['otp'] == $otp_input) {
        echo "<script>
            alert('OTP verified successfully.');
            window.location.href = 'forgot-password.php?step=reset';
        </script>";
    } else {
        echo "Invalid OTP. Please try again.";
    }
}

// Step 3: Handle password reset
if (isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $email = $_SESSION['EmailId'];

    // Hash the new password
    $hashed_password = custom_hash($new_password);
    $updateQuery = "UPDATE tblusers SET password = :password WHERE EmailId = :email";
    $stmt = $dbh->prepare($updateQuery);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    // Clear the session
    unset($_SESSION['otp']);
    unset($_SESSION['EmailId']);
    
    // Redirect to login page
    echo "<script>
        alert('Password has been reset successfully.');
        window.location.href = 'signin.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        /* Styles for the form */
        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
            padding: 20px;
            border-radius: 20px;
            background-color: #555a4a4a;
            color: #ffff;
            border: 1px solid #333;
            margin-top: 30vh;
            margin-left: auto;
            margin-right: auto;
        }
        .title {
            font-size: 28px;
            font-weight: 600;
            text-align: center;
            color: #00bfff;
        }
        .message {
            text-align: center;
            color: red;
        }
        .input {
            background-color: #333;
            color: #fff;
            width: 85%;
            padding: 10px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }
        .submit {
            align-self:center;
            width: 50%;
            border: none;
            padding: 10px;
            border-radius: 10px;
            color: #fff;
            background-color: #00bfff;
            cursor: pointer;
        }
        .submit:hover {
            background-color: #00bfff96;
        }
    </style>
</head>
<body>
    <center>
    <form class="form" method="POST" onsubmit="return validateForm()">
    <?php
    // Step 1: Enter Email
    if (!isset($_GET['step'])) {
    ?>
        <p class="title">Forgot Password?</p>
        <p class="message">Enter your registered Email</p>
        <label>
            <input class="input" type="email" name="EmailId" id="EmailId" placeholder="Enter Email" required>
        </label> 
        <button class="submit" type="submit">Submit</button>

    <?php
    // Step 2: Verify OTP
    } elseif ($_GET['step'] == 'verify') {
    ?>
        <p class="title">Verify OTP</p>
        <p class="message">Enter the 6-digit OTP sent to your email</p>
        <label>
            <input class="input" type="text" name="otp" placeholder="Enter OTP" required>
        </label> 
        <button class="submit" name="otp_verify" type="submit">Verify OTP</button>

    <?php
    // Step 3: Reset Password
    } elseif ($_GET['step'] == 'reset') {
    ?>
        <p class="title">Reset Password</p>
        <p class="message">Enter your new password</p>
        <label>
            <input class="input" type="password" name="new_password" id="new_password" placeholder="New Password" required>
        </label> 
        <button class="submit" name="reset_password" type="submit">Reset Password</button>
    <?php
    }
    ?>
</form>

<script>
   function validateForm() {
       <?php if (isset($_GET['step']) && $_GET['step'] == 'reset') { ?>
       // Password validation: must start with a letter, have at least 8 characters, and contain at least one special character
       const password = document.getElementById('new_password').value;
       const passwordRegex = /^[a-zA-Z][\w!@#$%^&*]{7,}$/;  // Starts with letter, 8 characters long, one special char

       if (!passwordRegex.test(password)) {
           alert("Password must start with a letter, be at least 8 characters long, and contain at least one special character.");
           return false;
       }
       <?php } ?>

       return true; // Allow form submission if all validations pass
   }
</script>

    </center>
</body>
</html>
