<?php
require('classes.php');
require('config.php');
$dbcon = new config();
$details = new User();

$message="";
$errors=array();
if(isset($_POST['submit'])){
	$datesignup=date("Y/m/d");
	$user_name=isset($_POST['user_name'])?$_POST['user_name']:'';
	$name=isset($_POST['name'])?$_POST['name']:'';
	$password=isset($_POST['password'])?$_POST['password']:'';
	$repassword=isset($_POST['repassword'])?$_POST['repassword']:'';
	$mobile=isset($_POST['mobile'])?$_POST['mobile']:'';
	if($password != $repassword){
		$errors[]=array("input"=>"password","msg"=>"password didn't match");
		echo "password didn't match";
	}
	else if(strlen($password) < 6){
		echo "<center><h3> Password length should be greater than 6 characters</h3></center>";	
	}
	else{
	$details -> signup($user_name,$name,$password,$mobile,$datesignup,$dbcon-> conn);			
	}
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
	 <header>
        <nav class="navbar navbar-expand-lg navbar-light  p-2 ">
          <a href="#" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a href="index.php" class = "btn btn-success ml-auto mr-5">Back To Home</a>
        </nav>
      </header>
		<div id="signup-form">
			<h2>Sign Up</h2>
			<form action="signup.php" method="POST" id="signup">
				<p>
					<label for="user_name">Username: <input type="text" name="user_name" required></label>
				</p>
				<p>
					<label for="user_name">Name: <input type="text" name="name" required></label>
				</p>
				<p>
					<label for="password">Password: <input type="password" name="password" required ></label>
				</p>
				<p>
					<label for="repassword">Re-Password: <input type="password" name="repassword" required ></label>
				</p>
				<p>
					<label for="date">Date of SignUp: <input type="date" name="date" required></label>
				</p>
				<p>
					<label for="mobile">Mobile: <input type="text" name="mobile" onkeypress="return onlynumber(event)"   required></label>
				</p>
				<p>
					<input type="submit" name="submit" value="Submit">
				</p>
				<p class="already">
					Already a user??
					<a href="login.php"><b>Log In</b></a>
				</p>
			</form>
		</div>	 
</body>
</html>