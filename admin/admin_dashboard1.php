<?php
session_start();
require('../classes.php');
require('../config.php');
require('../ride.php');
require('../location_classes.php');

$dbcon = new config();
if(!$_SESSION['admindata']) {
  header("location:../login.php");
}   
if(isset($_GET['logid'])){ 
    session_destroy();
    unset($_SESSION['admindata']);
    echo "You are Logged out";
    header('Location:../login.php');
  }
$numrequest = new User();
$ride =new Ride();
$location = new location();

$numpending = $numrequest -> numPendingRequests($dbcon-> conn);
$numusers = $numrequest -> totalusers($dbcon-> conn);
$numpendingUser = $numrequest -> noPendingUsers($dbcon-> conn);
$totalExpend= $ride -> Totalexpenditure($dbcon-> conn);
$numapprovedUser = $numrequest -> noApprovedUsers($dbcon-> conn);
$numrides = $ride -> totalrides($dbcon-> conn);
$numPendingRides = $ride -> noPendingRides($dbcon-> conn);
$numCompletedRides = $ride -> noCompletedRides($dbcon-> conn);
$numLocation = $location -> totallocation($dbcon-> conn);
$numAvailLocation = $location -> numAvailableLocation($dbcon-> conn);
$numNotAvailLocation = $location -> notAvailableLocation($dbcon-> conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style1.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
	<!--  <a href="../index.php" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3 h2" aria-hidden="true"></i><span class="h2 text-primary cab">CedCab</span></a>
	 <a href="admin_dashboard1.php?logid=logout" class="btn btn-primary float-right mr-3 mt-3" >Log OUT</a></h1> -->
	<header class="headerall">
        <nav class="navbar navbar-expand-lg navbar-light p-3 ">
          <a href="../index.php" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3 text-primary" aria-hidden="true"></i><span class="h4 text-primary cab">CedCab</span></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a href="admin_dashboard1.php?logid=logout" class="btn btn-primary ml-auto" >Log OUT</a>
        </nav>
      </header>

	<div class="btn1">
		<span class="fa fa-bars"></span>
	</div>
	
	
	<nav class= "sidebar">

		<a href="../index.php" class="navbar-brand mt-4 display-4 pl-5"><i class="fa fa-taxi h3 mr-3" aria-hidden="true"></i><span class="display-5 text-primary  cab">CedCab</span></a>
		<ul>
			<li><a href="admin_dashboard1.php" >Home</a></li>
			<li><a href="#" class="feat-btn" >Rides <span class="fa fa-caret-down first"></span></a>
				<ul class="feat-show">
					<li><a href="adminfunc.php?pendingrides=pendingrides" >Pending Rides</a></li>
					<li><a href="adminfunc.php?completedrides=completedrides" >Completed Rides</a></li>
					<li><a href="adminfunc.php?cancelledrides=cancelledrides" >Cancelled Rides</a></li>
					<li><a href="adminfunc.php?allrides=allrides" >All Rides</a></li>
				</ul>
			</li>
			
			<li><a href="#" class="serv-btn">Users<span class="fa fa-caret-down second"></span></a>
				<ul class="serv-show">
					<li><a href="adminfunc.php?pendingrequest=pendingrequest" >Pending user request</a></li>
					<li><a href="adminfunc.php?approveduser=approveduser" >Approved user request</a></li>
					<li><a href="adminfunc.php?alluser=alluser" >All user</a></li>
				</ul>
			</li>	

			<li><a href="#" class="loc-btn">Location<span class="fa fa-caret-down second"></span></a>
				<ul class="loc-show">
					<li><a href="adminfunc.php?location=location" >Location List</a></li>
					<li><a href="adminfunc.php?addlocation=addlocation" >Add new Location</a></li>
				</ul>
			</li>	

			<li><a href="#" class="acc-btn">Account<span class="fa fa-caret-down second"></span></a>
				<ul class="acc-show">
					<li><a href="adminfunc.php?changepass=changepass">Change Password</a></li>
				</ul>
			</li>	
		</ul>
	</nav>

	<div id="main">
	  <section id="pendingrequest">
	  </section>

	  <section id="request">

	  </section>

	  <h1 class="text-center"><?php echo "Welcome " .$_SESSION['admindata']['adminname'] ?> in  Admin Panel</h1>
	  
	<div class="row">
 	<div class="col-lg-4">
 		<div class="card text-white bg-success mb-3 text-center">
		  <div class="card-header">Ride</div>
		  <div class="card-body">
		    <h5 class="card-title">Total Earning</h5>
		    <p class="card-text"><?php print_r($totalExpend[0]) ; echo "  Rs." ?></p>
		  </div>
		   <div class="card-footer"><a href="adminfunc.php?allrides=allrides" >Get More Details</a></div>
		</div>
 		<div class="card text-white bg-success mb-3 text-center">
		  <div class="card-header">USER</div>
		  <div class="card-body">
		    <h5 class="card-title">Total Users</h5>
		    <p class="card-text"><?php echo $numusers ?></p>
		  </div>
		   <div class="card-footer"><a href="adminfunc.php?alluser=alluser" >Get More Details</a></div>
		</div>
		<div class="card text-white bg-success mb-3 text-center">
		  <div class="card-header">USER</div>
		  <div class="card-body">
		    <h5 class="card-title">Pending Users</h5>
		    <p class="card-text"><?php echo $numpendingUser; ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?pendingrequest=pendingrequest" >Get More Details</a></div>
		</div>
		
	</div>
	 <div class="col-lg-4">
		<div class="card text-white bg-info mb-3 text-center">
		  <div class="card-header">RIDE</div>
		  <div class="card-body">
		    <h5 class="card-title">Total Rides</h5>
		    <p class="card-text"><?php echo $numrides ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?allrides=allrides" >Get More Details</a></div>
		</div>
		<div class="card text-white bg-info mb-3 text-center">
		  <div class="card-header">RIDE</div>
		  <div class="card-body">
		    <h5 class="card-title">Pending Rides</h5>
		    <p class="card-text"><?php echo $numPendingRides ?> </p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?pendingrides=pendingrides" >Get More Details</a></div>
		</div>
		<div class="card text-white bg-info mb-3 text-center">
		  <div class="card-header">RIDE</div>
		  <div class="card-body">
		    <h5 class="card-title">Completed Rides</h5>
		    <p class="card-text"><?php echo $numCompletedRides ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?completedrides=completedrides" >Get More Details</a></div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card text-white bg-danger mb-3 text-center">
		  <div class="card-header">LOCATION</div>
		  <div class="card-body">
		    <h5 class="card-title">Total Location</h5>
		    <p class="card-text"><?php echo $numLocation ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?location=location" >Get More Details</a></div>
		</div>
		<div class="card text-white bg-danger mb-3 text-center">
		  <div class="card-header">LOCATION</div>
		  <div class="card-body">
		    <h5 class="card-title">Available Location</h5>
		    <p class="card-text"><?php echo $numAvailLocation ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?location=location" >Get More Details</a></div>
		</div>
		<div class="card text-white bg-success mb-3 text-center">
		  <div class="card-header">USER</div>
		  <div class="card-body">
		    <h5 class="card-title">Approved Users</h5>
		    <p class="card-text"><?php echo $numapprovedUser ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?approveduser=approveduser" >Get More Details</a></div>
		</div>
		<!-- <div class="card text-white bg-danger mb-3 text-center">
		  <div class="card-header">LOCATION</div>
		  <div class="card-body">
		    <h5 class="card-title">Locations not Available</h5>
		    <p class="card-text"><?php //echo $numNotAvailLocation ?></p>
		  </div>
		  <div class="card-footer"><a href="adminfunc.php?location=location" >Get More Details</a></div>
		</div> -->
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
	</div>

<script>
	$('.btn1').click(function(){
		$(this).toggleClass("click");
		$('.sidebar').toggleClass("show");
		$('#main').toggleClass("show3");

	});

	$('.feat-btn').click(function(){
		$('nav ul .feat-show').toggleClass("show");
		$('nav ul .first').toggleClass("rotate");
	});

	$('.serv-btn').click(function(){
		$('nav ul .serv-show').toggleClass("show1");
		$('nav ul .second').toggleClass("rotate");
	});

	$('.loc-btn').click(function(){
		$('nav ul .loc-show').toggleClass("show2");
	});

	$('.acc-btn').click(function(){
		$('nav ul .acc-show').toggleClass("show3");
	});
	$('nav ul li').click(function(){
		$(this).addClass("active").siblings().removeClass("active");
	});
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>