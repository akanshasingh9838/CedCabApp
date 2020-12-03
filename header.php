<?php
session_start();

if(isset($_GET['logid'])){ 
    session_destroy();
    unset($_SESSION['userdata']);
    unset($_SESSION['ride']);
    echo "You are Logged out";
  }
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
              <li class="nav-item">
                <a href="login.php" class="nav-link text-success">Log In</a>
              </li>
               <li class="nav-item">
                <a href="signup.php" class="nav-link text-success">Sign Up</a>
              </li>
              <?php if(isset($_SESSION['userdata'])){ ?>
              <li class="nav-item">
                <a href="index.php?logid=logout" class="btn btn-success ml-3">Log Out</a>
              </li>
            <?php }?>
            </ul>
          </div>     
        </nav>
      </header>