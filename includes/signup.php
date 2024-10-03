<?php
error_reporting(0);
if(isset($_POST['submit']))
{
$fname=$_POST['fname'];
$mnumber=$_POST['mobilenumber'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$sql="INSERT INTO  tblusers(FullName,MobileNumber,EmailId,Password) VALUES(:fname,:mnumber,:email,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mnumber',$mnumber,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="You are Scuccessfully registered. Now you can login ";
header('location:thankyou.php');
}
else 
{
$_SESSION['msg']="Something went wrong. Please try again.";
header('location:thankyou.php');
}
}
?>
<!--Javascript for check email availabilty-->
<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						</div>
							<section>
								<div class="modal-body modal-spa">
									<div class="login-grids">
										<div class="login">
											<div class="login-left">
												<ul>
													<li><a class="fb" href="#"><i></i>Facebook</a></li>
													<li><a class="goog" href="#"><i></i>Google</a></li>
													
												</ul>
											</div>
											<div class="login-right">
    <form name="signup" method="post" onsubmit="return validateForm()">
        <h3>Create your account</h3>

        <input type="text" value="" placeholder="Full Name" name="fname" id="fname" autocomplete="off" required="">
        <input type="text" value="" placeholder="Mobile number" maxlength="10" name="mobilenumber" id="mobilenumber" autocomplete="off" required="">
        <input type="text" value="" placeholder="Email id" name="email" id="email" onBlur="checkAvailability()" autocomplete="off" required="">
        <span id="user-availability-status" style="font-size:12px;"></span>
        <input type="password" value="" placeholder="Password" name="password" id="password" required="">
        <input type="submit" name="submit" id="submit" value="CREATE ACCOUNT">
    </form>
</div>

<div class="clearfix"></div>
<p>By logging in you agree to our <a href="page.php?type=terms">Terms and Conditions</a> and <a href="page.php?type=privacy">Privacy Policy</a></p>

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
        var mobilePattern = /^\d{10}$/;
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

        // Password validation (minimum 6 characters)
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        // If all validations pass, submit the form
        return true;
    }

    // Function to check availability (could be an AJAX call)
    function checkAvailability() {
        // For demonstration purposes, you can add your AJAX code here
        var email = document.getElementById("email").value;
        document.getElementById("user-availability-status").innerHTML = email ? "Checking..." : "";
        // You can make an AJAX call to your server to check if the email already exists
    }
</script>

							</section>
					</div>
				</div>
			</div>