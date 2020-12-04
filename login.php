<?php
session_start();
require('classes.php');
require('config.php');
require 'ride.php';
$dbcon = new config();
$details = new User();



if(isset($_SESSION['userdata']))
{
	echo "<script>window.location = 'user_dashboard.php'</script>";
}

if(isset($_SESSION['admindata']))
{
	echo "<script>window.location = 'admin/admin_dashboard1.php'</script>";
}




if(isset($_POST['submit'])){
	$username=trim(isset($_POST['username'])?$_POST['username']:'');
	$password=trim(isset($_POST['password'])?$_POST['password']:'');
	$msg = $details ->login($username , $password ,$dbcon-> conn);
	if($msg == "falsee"){
		echo "<script>alert('You have to first log out to log in again...')</script>";
	}
	if($msg == "ride_created"){
	    $bookdetails = new Ride();
	    $b=$bookdetails -> insertBookDetails($dbcon->conn);
	    echo $b;

	    header('Location:user_dashboard.php');
	}
}
if(isset($_GET['logid'])){ 
    session_destroy();
    unset($_SESSION['admindata']);
    unset($_SESSION['userdata']);
    echo "You are Logged out";
    header('Location:login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Login
	</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
	<div id="message"><?php echo $details -> message; ?></div>
	 <header class="headerall">
        <nav class="navbar navbar-expand-lg navbar-light p-3 ">
          <a href="index.php" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
            <span class="navbar-toggler-icon"></span>
          </button>
        <!--   <a href="index.php" class = "btn  btn-success  ml-auto mr-5">Back To Home</a> -->
          <?php if(isset($_SESSION['userdata'])|| isset($_SESSION['admindata'])){ ?>
          	<a href="login.php?logid=logout" class="btn btn-success float-right ml-auto mr-5" >Log OUT</a>
           <?php } ?>
        </nav>
      </header>



	<div id="login-form">
		<h2>Login</h2>
		<form action="" method="POST">
			<p>
				<label for="username">Username: <input type="text" name="username" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];}?> " required></label>
			</p>
			<p>
				<label for="password">Password: <input type="password" name="password" required></label>
			</p>
			<p>
				<label for="remember" style="font-size: 20px;">Remember Me: </label><input type="checkbox" name="remember" class="remember">			
			</p>
			<p>
				<input type="submit" name="submit" value="Submit">
			</p>
			<p class="already">
				Not a user??
				<a href="signup.php"><b>Register Here</b></a>
			</p>
		</form>
	</div>
	
    <footer class="text-center">
      <div class="row pt-4">
        <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4  icons">
          <i class="fab fa-facebook pr-4"></i>
          <i class="fab fa-twitter-square pr-4"></i>
          <i class="fas fa-camera"></i>
        </div>
        <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 mt-2">
          <p class="h2 text-success">CedCab</p>
          <p>All rights are reserved Copyright@2020</p>
        </div>
        <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 mt-2">
          <nav>
            <a href="#" class="pr-4">Features</a>
            <a href="#" class="pr-4">Reviews</a>
            <a href="#" >Sign Up</a>
          </nav>
        </div>
      </div>
    </footer>
	</body>
</html>