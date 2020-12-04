<?php
session_start();
require 'classes.php';  
require 'location_classes.php';
require 'config.php';
require 'ride.php';

$dbcon = new config();
if(isset($_GET['bookid'])){
  if(isset($_SESSION['userdata'])){
    $bookdetails = new Ride();
    $b=$bookdetails -> insertBookDetails($dbcon->conn);
    echo "<script>alert('".$b."')</script>";
  }
   else{
     header('Location: login.php');
  }
}

if(isset($_GET['logid'])){ 
    if(isset($_SESSION['userdata'])){
      session_destroy();
      unset($_SESSION['userdata']);
      unset($_SESSION['ride']);
      header("location:index.php");
      echo "You are Logged out";
    }
  }

$Location = new location();
  $data = $Location->fetchLocation($dbcon->conn);
?> 

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="file.js"></script>
    <title>Cab Booking</title>
  </head>
  <body>
     <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-2 ">
          <a href="#" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbar_menu">
            <ul class="navbar-nav ml-auto mr-5">
              <li class="nav-item">
                <a href="#" class="nav-link text-success">About Us</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link text-success">Contact Us</a>
              </li>
              <?php if(!isset($_SESSION['userdata'])) { ?>
                <li class="nav-item">                 
                  <a href="login.php" class="nav-link text-success">Log In</a>
                </li>
                <li class="nav-item">
                  <a href="signup.php" class="nav-link text-success">Sign Up</a>
                </li>
                <?php } ?>
            
              <?php if(isset($_SESSION['userdata'])) { ?>
              <li class="nav-item">
                <a href="index.php?logid=logid" class="btn btn-success ml-3">Log Out</a>
              </li>

              <li class="nav-item">
                <a href="user_dashboard.php" class="btn btn-success ml-3">User Dashboard</a>
              </li>
            <?php } ?>
            </ul>
          </div>     
        </nav>
      </header>
    <div class="container-fluid text-center mt-5">
        <h1 class="display-5 font-weight-bold head">Book a City Taxi to your destination in Town</h1>
        <p class="lead head">Choose from a range of categories and prices</p>
            <div class="row mt-4">
                    <div class="col-lg-5 col1 m-5 p-3">
                    <div class="form-head p-3"><span class="bg-success p-2">CITY TAXI</span></div>
                    <p class="h5 font-weight-bold mt-3">Your everybody travel partner</p>
                    <p class="h6 mb-3">AC Cabs for point to point travel</p>
                    <form action="index.php" method="post" >
                        <div class="form-group">
                            <select class="form-control g" id="pickup" name="pickup">
                              <option selected disabled><span class="small_holder"></span>Current Location</option>
                              <?php
                              
                                foreach($data as $row) {
                              ?>
                              <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                <?php }?>
                          
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control g" id="drop" name="drop">
                              <option selected disabled><span class="small_holder"></span>Enter drop for ride estimate</option>
                              <?php
                              
                                foreach($data as $row) {
                              ?>
                              <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control g" id="cabtype">
                              <option selected disabled>Drop down to select CAB Type</option>
                              <option value = "cedMicro">CedMicro</option>
                              <option value = "cedMini">CedMini</option>
                              <option value = "cedRoyal">CedRoyal</option>
                              <option value = "cedSUV">CedSUV</option>
                            </select>
                        </div>

                         <div class="form-group">
                            <input type="text"  class="form-control" id="luggage" onkeypress="return onlynumber(event)" placeholder="Enter weight of luggage in kg">
                        </div>

                        <button type="button" id="button" class="btn btn-success btn-block btn-lg" >Calculate Fare</button>
                        <div class="form-group mt-3">
                            <input type="text"  class="form-control text-center" id="fare" disabled>
                            
                        </div>
                        <a href="index.php?bookid=bookid" class="btn btn-info btn-block btn-lg" id="book" >Book Your Cab</a>
                    </form>
                </div>
                <div class="col-lg-7"></div>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>




