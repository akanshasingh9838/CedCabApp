<?php
session_start();
require('classes.php');
require('config.php');
require('ride.php');
$dbcon = new config();
if(!$_SESSION['userdata']) {
  header("location:login.php"); 
}   
if(isset($_GET['logid'])){ 
    session_destroy();
    unset($_SESSION['userdata']);
    unset($_SESSION['ride']);
    echo "You are Logged out";
    header('Location:login.php');
  }
$id=$_SESSION['userdata']['user_id'];
$numrequest = new User();
$ride =new Ride();
$totalUserExpend= $ride -> TotalUserexpenditure($dbcon-> conn,$id);
$numtotalUserRides = $ride -> totalUserRides($dbcon-> conn,$id);
$numUserPendingRides = $ride -> noUserPendingRides($dbcon-> conn,$id);
$numUserCompletedRides = $ride -> noUserCompletedRides($dbcon-> conn,$id);
$numUserCancelledRides = $ride-> noUserCancelledRides($dbcon-> conn,$id);
$noUserLocations= $ride -> noUserLocations($dbcon-> conn,$id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
   <header class="headerall">
        <nav class="navbar navbar-expand-lg navbar-light p-3 ">
          <a href="index.php" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- <a href="index.php" class = "btn btn-success ml-auto mr-5">Back To Home</a> -->
          <a href="user_dashboard.php?logid=logout" class="btn btn-primary ml-auto mr-5" >Log OUT</a>
        </nav>
      </header>

  <div class="btn1">
    <span class="fa fa-bars"></span>
  </div>
  <nav class= "sidebar">
    <a href="#" class="navbar-brand pl-5 mt-3"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>

    <ul>
      <li><a href="user_dashboard.php" >Home</a></li>
      <li><a href="index.php" >Book New Ride</a></li>
      <li><a href="#" class="feat-btn" >Rides <span class="fa fa-caret-down first"></span></a>
        <ul class="feat-show">
          <li><a href="userfunc.php?pendingrides=pendingrides" >Pending Rides</a></li>
          <li><a href="userfunc.php?completedrides=completedrides" >Completed Rides</a></li>
          <li><a href="userfunc.php?cancelledrides=cancelledrides" >Cancelled Rides</a></li>
          <li><a href="userfunc.php?allrides=allrides" >All Rides</a></li>
        </ul>
      </li>
      <li><a href="#" class="acc-btn">Account<span class="fa fa-caret-down second"></span></a>
        <ul class="acc-show">
           <li><a href="userfunc.php?updateinfo=updateinfo"id="updateInfoBtn" >Update Information</a></li>
          <li><a href="userfunc.php?changepass=changepass" >Change Password</a></li>
        </ul>
      </li> 
    </ul>
  </nav>
   
  <div id="main">



    <section id="pendingrequest">
    </section>

    <section id="request">
    </section>
      
    <h1 class="text-center wlcmhead"><?php echo "Welcome " .$_SESSION['userdata']['username'] ?> "!!"</h1>
    <?php if(isset($_SESSION['ride'])){
      echo "<center><h2>Your Ride Is Pending</h2></center>";
    }
    else{
      unset($_SESSION['ride']);
    }
    ?>
  <div class="row">
  <div class="col-lg-4">
    <div class="card text-white bg-success mb-3 text-center">
      <div class="card-header">Ride</div>
      <div class="card-body">
        <h5 class="card-title">Total Expenditure</h5>
        <p class="card-text"><?php print_r($totalUserExpend[0]) ?>  Rs.</p>
      </div>
       <div class="card-footer"><a href="userfunc.php?allrides=allrides" >Get More Details</a></div>
    </div>
    <div class="card text-white bg-success mb-3 text-center">
      <div class="card-header">Rides</div>
      <div class="card-body">
        <h5 class="card-title">Your Total Rides</h5>
        <p class="card-text"><?php echo $numtotalUserRides ?></p>
      </div>



      <div class="card-footer"><a href="userfunc.php?allrides=allrides" >Get More Details</a></div>
    </div>
  </div>


   <div class="col-lg-4">
    <div class="card text-white bg-info mb-3 text-center">
      <div class="card-header">RIDE</div>
      <div class="card-body">
        <h5 class="card-title">Your Completed Rides</h5>
        <p class="card-text"><?php echo $numUserCompletedRides  ?></p>
      </div>
      <div class="card-footer"><a href="userfunc.php?completedrides=completedrides" >Get More Details</a></div>
    </div>
    <div class="card text-white bg-info mb-3 text-center">
      <div class="card-header">RIDE</div>
      <div class="card-body">
        <h5 class="card-title">Your Cancelled Rides</h5>
        <p class="card-text"><?php echo $numUserCancelledRides ?> </p>
      </div>
      <div class="card-footer"><a href="userfunc.php?cancelledrides=cancelledrides" >Get More Details</a></div>
    </div>
   
  </div>
  <div class="col-lg-4">
    <div class="card text-white bg-danger mb-3 text-center">
      <div class="card-header">LOCATION</div>
      <div class="card-body">
        <h5 class="card-title">Travelled Places</h5>
        <p class="card-text"><?php echo $noUserLocations ?></p>
      </div>
      <div class="card-footer"><a href="userfunc.php?completedrides=completedrides" >Get More Details</a></div>
    </div>
     <div class="card text-white bg-success mb-3 text-center">
      <div class="card-header">USER</div>
      <div class="card-body">
        <h5 class="card-title">Your Pending Rides</h5>
        <p class="card-text"><?php echo $numUserPendingRides  ?></p>
      </div>
      <div class="card-footer"><a href="userfunc.php?pendingrides=pendingrides" >Get More Details</a></div>
    </div>
  </div>
  </div>

  <?php if(isset($_SESSION['ride'])){ ?>
  <div class= "container text-center">
      <h2>Last Pending Ride Details</h2>
      <div class="row text-center">
        <div class="col">
          <section id="request">
              <table class="table table-bordered ml-5 mr-5">
                <tr><th>Pick Up Location </th><td><?php echo $_SESSION['ride']['pickup']; ?></td> </tr>
                <tr><th>Drop Up Location</th><td><?php echo $_SESSION['ride']['dropup'] ?></td></tr>
                <tr> <th>Cab Type</th><td><?php echo $_SESSION['ride']['cab'] ?></td></tr>
                <tr><th>Luggage Weight</th><td><?php echo $_SESSION['ride']['luggage'] ?></td> </tr>
                              
                <tr> <th>Distance Travelled</th><td><?php echo $_SESSION['ride']['distance'] ?></td></tr>
              
                <tr><th>Total Fare</th><td><?php echo $_SESSION['ride']['fare'] ?></td></tr>                                
                </table>
          </section>      
        </div>
      </div>
    </div>
<?php } ?>

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

  $('.acc-btn').click(function(){
    $('nav ul .acc-show').toggleClass("show3");
  });
  $('nav ul li').click(function(){
    $(this).addClass("active").siblings().removeClass("active");
  });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>