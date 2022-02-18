
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

<!--===============================================================================================-->


    <?php

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
       // echo "Connection succesfull";
    }

    /* $sql = "INSERT INTO accounts (email,password,first_name,last_name) VALUES ('admin','admin','admin','admin');";

    if(mysqli_query($conn, $sql))
    {
        echo "Querry succesfull.";
    }
    else
    {
        echo "Querry failed";
    }

    */

    ?>

    <?php

        if(array_key_exists('loginButton', $_POST)) { 
            loginButton(); 
        } 
        if(array_key_exists('registerButton', $_POST)) { 
            header('Location: register.php');
        } 

        function loginButton() { 
            //echo " This is Button1 that is selected"; 

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
                if(isset($_POST["email"]))
                {
                    $inputEmail = $_POST['email'];
                }
                if(isset($_POST["pass"]))
                {
                    $inputPassword = $_POST['pass'];
                }

                $sql = "SELECT * FROM accounts WHERE email LIKE '$inputEmail' AND password LIKE '$inputPassword';";
                
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) 
                {
                    $row = mysqli_fetch_row($result);

                    session_start();

                    $_SESSION['userID'] = $row[0];
                    $_SESSION['firstName'] = $row[3];
                    $_SESSION['lastName'] = $row[4];
                    $_SESSION['friendList'] = $row[5];


                    

                    header('Location: mainPage.php');
                } 
                else 
                {
                    echo "Invalid account";
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
						Social Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
                        <button type = "submit" name="loginButton" value="loginButton"class="login100-form-btn">
							Login
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