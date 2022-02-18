
 <!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    
    <?php

    if(array_key_exists('registerButton', $_POST)) { 
       attemptRegister();
    } 
    function attemptRegister()  
    {
        $servername = "localhost";
        $username = "root";
        $dbname = "social_db";
        $conn = new mysqli($servername, $username,"",$dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
            $inputEmail = $_POST['email'];
            $inputPassword = $_POST['pass'];
            $inputFirstName = $_POST['first_name'];
            $inputLastName = $_POST['last_name'];

            $sql = "INSERT INTO accounts (email,password,first_name,last_name) VALUES ('$inputEmail','$inputPassword','$inputFirstName','$inputLastName');";

            if(mysqli_query($conn, $sql))
            {
                echo "Register Succesfull";
                header('Location: index.php');
            }
        }
    }

    ?>

</head>

<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/login-avatar.jpg" alt="IMG">
				</div>

				<form method = "post" class="login100-form validate-form">
					<span class="login100-form-title">
						Social Register
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
                    </div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="text" name="first_name" placeholder="First Name">
						<span class="focus-input100"></span>
                    </div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="text" name="last_name" placeholder="Last Name">
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
                        <button type = "submit" name="registerButton" value="registerButton"class="login100-form-btn">
							Register
						</button>
                    </div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
                            <button type = "submit" name="registerButton" value="registerButton">
                                Create your Account
                            </button>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
</body>
</html>