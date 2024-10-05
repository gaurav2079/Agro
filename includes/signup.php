<?php
error_reporting(0);

// Custom password hashing function
function custom_hash($password) {
    $salt = '123asaaks@#$'; 
    $hashed = '';
    for ($i = 0; $i < strlen($password); $i++) {
        $hashed .= dechex(ord($password[$i]) + ord($salt[$i % strlen($salt)]));
    }
    return $hashed;
}

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $mnumber = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $password = custom_hash($_POST['password']);
    $sql = "INSERT INTO tblusers (FullName, MobileNumber, EmailId, Password) VALUES (:fname, :mnumber, :email, :password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mnumber', $mnumber, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $_SESSION['msg'] = "You are successfully registered. Now you can login.";
        header('location:thankyou.php');
    } else {
        $_SESSION['msg'] = "Something went wrong. Please try again.";
        header('location:thankyou.php');
    }
}
?>

<!-- Javascript for check email availability -->
<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: 'emailid=' + $("#email").val(),
        type: "POST",
        success: function(data) {
            $("#user-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {}
    });
}
</script>

<style>
/* Glowing animation */
@keyframes glow {
    0% {
        box-shadow: 0 0 5px rgba(255, 255, 255, 0.5), 0 0 10px rgba(255, 255, 255, 0.5), 0 0 15px rgba(255, 255, 255, 0.5);
    }
    50% {
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 20px rgba(255, 255, 255, 0.8), 0 0 30px rgba(255, 255, 255, 0.8);
    }
    100% {
        box-shadow: 0 0 5px rgba(255, 255, 255, 0.5), 0 0 10px rgba(255, 255, 255, 0.5), 0 0 15px rgba(255, 255, 255, 0.5);
    }
}

body {
    background-color: #f2f2f2; /* Optional: Background color for the page */
}

.modal-content {
    background-image: url('images/1.jpg');
    background-size: cover;
    background-position: center;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Ensure it takes full height */
}

.modal-body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Full height */
}

.login-grids {
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    animation: glow 1.5s infinite; /* Apply glowing animation */
    transition: all 0.3s ease;
    max-width: 400px; /* Set a max-width for the form */
    width: 100%; /* Make it responsive */
    margin: 20px; /* Margin around the form */
}

.login-grids:hover {
    background: rgba(255, 255, 255, 0.9); /* Slightly increase opacity on hover */
}

h3 {
    text-align: center;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

input[type="text"]:focus, input[type="password"]:focus {
    border-color: #0088cc; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

input[type="submit"] {
    background-color: #0088cc;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 250%;
}

input[type="submit"]:hover {
    background-color: #005f99; /* Darken button on hover */
}
</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
            </div>
            <section>
                <div class="modal-body modal-spa">
                    <div class="login-right">
                        <form name="signup" method="post" onsubmit="return validateForm()">
                            <div class="login-grids">
                                <h3>Create your account</h3>
                                <input type="text" value="" placeholder="Full Name" name="fname" id="fname" autocomplete="off" required="">
                                <input type="text" value="" placeholder="Mobile number" maxlength="10" name="mobilenumber" id="mobilenumber" autocomplete="off" required="">
                                <input type="text" value="" placeholder="Email id" name="email" id="email" onBlur="checkAvailability()" autocomplete="off" required="">
                                <span id="user-availability-status" style="font-size:12px;"></span>
                                <input type="password" value="" placeholder="Password" name="password" id="password" required="">
                                <input type="submit" name="submit" id="submit" value="CREATE ACCOUNT">
                            </div>
                        </form>
                    </div>

                    <script>
                        // Function to validate the form
                        function validateForm() {
                            var fname = document.getElementById('fname').value;
                            var mobile = document.getElementById('mobilenumber').value;
                            var email = document.getElementById('email').value;
                            var password = document.getElementById('password').value;
                            
                            // Name validation (letters only)
                            var namePattern = /^[A-Za-z\s]+$/;
                            if (!namePattern.test(fname)) {
                                alert("Full Name must contain only letters.");
                                return false;
                            }

                            // Mobile number validation (10 digits)
                            var mobilePattern = /^(98|97)\d{8}$/;
                            if (!mobilePattern.test(mobile)) {
                                alert("Mobile number must be exactly 10 digits.");
                                return false;
                            }

                            // Email validation
                            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailPattern.test(email)) {
                                alert("Please enter a valid email address.");
                                return false;
                            }

                            // Password validation: Must be at least 8 characters, start with a letter, and have at least one special character
                            var passwordPattern = /^[a-zA-Z][\w!@#$%^&*]{7,}$/;
                            if (!passwordPattern.test(password)) {
                                alert("Password must start with a letter, be at least 8 characters long, and contain at least one special character.");
                                return false;
                            }

                            // If all validations pass, submit the form
                            return true;
                        }
                    </script>
                </div>
            </section>
        </div>
    </div>
</div>
