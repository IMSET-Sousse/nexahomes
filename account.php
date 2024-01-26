<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php require('./header.php') ?>

<div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <span class="breadcrumb"><a href="#">Home</a>  /  Register & Login</span>
          <h3>Account</h3>
        </div>
      </div>
    </div>
  </div>

					<?php
					
					// Database connection details
					$host = "localhost";       // Hostname of the database server
					$user = "root";            // Database username
					$password = "";            // Database password
					$database = "test_db";     // Database name
					// Create a new mysqli object for establishing a database connection
					$conn = new mysqli($host, $user, $password, $database);
					if ($conn->connect_error) {
						// If connection fails, terminate the script and display an error message
						die("Connection failed: " . $conn->connect_error);
					}
					
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST["login"])) {
				$username = $_POST["username"];
				$password = $_POST["password"];

				$requete = "SELECT * FROM authentification where login='".$username."' and password = '".$password."'";

				$query = $conn->query($requete);		
				$num = $query->num_rows;
				// Simple validation (you can replace this)
				if ($num>0) {
					while($enreg = $query->fetch_assoc()){
						$_SESSION['ID'] = $enreg['id'];
					}
					header("Location: index.php");
					echo "<div>Login successful. Welcome, $username!</div>";
				} else {
					echo "<div>Login failed. Please check your username and password.</div>";
				}
			} elseif (isset($_POST["register"])) {
				$name = $_POST["name"];
				$phone = $_POST["phone"];
				$newUsername = $_POST["newUsername"];
				$newPassword = $_POST["newPassword"];

				$maxID = 0;
				$req="select max(id)+1 as maxID from authentification";
				$query = $conn->query($req);		
				while($enreg = $query->fetch_assoc()){
					$maxID = $enreg['maxID'];
				}

				$sql="INSERT INTO authentification(id, login, password, name, phone) VALUES ";
				$sql=$sql."('".$maxID."','".$newUsername."','".$newPassword."','".$name."','".$phone."')";
				$query = $conn->query($sql);
				$_SESSION['ID'] = $maxID;
				header("Location: index.php");
				// No real registration here; just display a message
				echo "<div>Registration successful. You can now log in with your new account.</div>";
			}
		}
					?>

<div class="col-16 text-center">
        <div class="form-container">
            <div class="form-btn">
                <span onclick="login()">Login</span>
                <span onclick="register()">Register</span>
                <hr id="indicator">
            </div>
            <!-- Login form -->
            <form id="loginform" method="POST">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" class="btn" name="login">Login</button>
            </form>

            <!-- Registration form -->
            <form id="rgform" method="POST">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="phone" placeholder="Phone">
                <input type="text" name="newUsername" placeholder="New Username">
                <input type="password" name="newPassword" placeholder="New Password">
                <button type="submit" class="btn" name="register">Register</button>
            </form>
        </div>
    </div>

    <?php require('./footer.php') ?>

    <!-- JS for form -->
    <script>
        var loginform = document.getElementById("loginform");
        var rgform = document.getElementById("rgform");
        var indicator = document.getElementById("indicator");

        function register(){
            rgform.style.transform = "translateX(0px)";
            loginform.style.transform = "translateX(0px)";
            indicator.style.transform = "translateX(100px)";
        }
        function login(){
            rgform.style.transform = "translateX(300px)";
            loginform.style.transform = "translateX(300px)";
            indicator.style.transform = "translateX(0px)";
        }
    </script>
				</div>
			</div>
		</div>	


	</body>
</html>