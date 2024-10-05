<?php
session_start();
// Uncomment the custom_hash function if you intend to use it
// function custom_hash($password) {
//     $salt = '123asaaks@#$'; 
//     $hashed = '';
//     for ($i = 0; $i < strlen($password); $i++) {
//         $hashed .= dechex(ord($password[$i]) + ord($salt[$i % strlen($salt)]));
//     }
//     return $hashed;
// }

if(isset($_POST['signin']))
{
    $email = $_POST['email'];
    $password = custom_hash($_POST['password']);
    echo $password;  // For debugging, to see what the hashed password looks like

    $sql = "SELECT id, EmailId, Password FROM tblusers WHERE EmailId=:email AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0)
    {
        $result = $results[0]; // Fetch the first result
        $_SESSION['login'] = $_POST['email'];
        $_SESSION['user_id'] = $result->id;
        echo "<script type='text/javascript'> document.location = 'package-list.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

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

.modal-content {
    background-image: url('images/1.jpg');
    background-size: cover;
    background-position: center;
    border: none;
}

.modal-body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.login-grids {
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    animation: glow 1.5s infinite; /* Apply glowing animation */
    transition: all 0.3s ease;
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
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #005f99; /* Darken button on hover */
}
</style>

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>						
            </div>
            <div class="modal-body modal-spa">
                <div class="login-grids">
                    <div class="login">
                        <div class="login-center">
                            <form method="post">
                                <h3>Signin with your account</h3>
                                <input type="text" name="email" id="email" placeholder="Enter your Email" required="">	
                                <input type="password" name="password" id="password" placeholder="Password" value="" required="">	
                                <h4><a href="forgot-password.php">Forgot password</a></h4>
                                <input type="submit" name="signin" value="SIGNIN">
                            </form>
                        </div>
                        <div class="clearfix"></div>								        
                    </div>
                    <p>By logging in you agree to our <a href="page.php?type=terms">Terms and Conditions</a> and <a href="page.php?type=privacy">Privacy Policy</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
