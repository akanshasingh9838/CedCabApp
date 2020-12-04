<?php
session_start();
require('classes.php');
require('config.php');
require('ride.php');
$dbcon = new config();
if(!$_SESSION['userdata']) {
  header("location:login.php"); 
}   
$rideobj =  new Ride();
$user = new user();
if(isset($_GET['pendingrides']) && $_GET['pendingrides'] == 'pendingrides'){
  $pendingrides =$rideobj -> userPendingRide($dbcon-> conn);
}

if(isset($_GET['completedrides']) && $_GET['completedrides'] == 'completedrides'){  
  $completedrides =$rideobj -> userCompletedRide($dbcon-> conn);
}
if(isset($_GET['cancelledrides']) && $_GET['cancelledrides'] == 'cancelledrides'){  
  $cancelledrides =$rideobj -> userCancelledRide($dbcon-> conn);
}
if(isset($_GET['allrides']) && $_GET['allrides'] == 'allrides'){  
  $allrides =$rideobj -> userAllRide($dbcon-> conn);
}
if(isset($_GET['logid'])){ 
    session_destroy();
    unset($_SESSION['userdata']);
    unset($_SESSION['ride']);
    echo "You are Logged out";
    header('Location:login.php');
  }

if(isset($_GET['deleteid']) && $_GET['action'] == 'delete'){  
  $item = $_GET['deleteid'];
  $rideobj-> deletePendingRide($item ,$dbcon-> conn);
  header('Location:userfunc.php?pendingrides=pendingrides');
}
// if(isset($_GET['updateinfo'])){ 
//  $msg = $user-> updateInfoBtn($_SESSION['user_id'],$dbcon -> conn);
//   }

// print_r($data);

if (isset($_POST['updateinfo'])) {
  // echo "hii";
  $name = $_POST['name'];
  $mobile = $_POST['mobile'];
  $id = $_POST['id'];
  // echo $name, $mobile, $id;
  if(preg_match('/^[0-9]{10}+$/', $mobile)) {  
    $msg = $user->updateUserInfo($name, $mobile, $id, $dbcon->conn);
  }
  else{
     echo "<script>alert('Enter valid mobile number');</script>";
  }

  echo "<script>alert('".$msg."');</script>";
  // header('Location:userfunc.php?updateinfo=updateinfo');
}
$data = $user->fetchDataUpdate($_SESSION['userdata']['user_id'], $dbcon->conn);
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
  <script src="file.js"></script>
</head>
<body>

  <header class="headerall">
        <nav class="navbar navbar-expand-lg navbar-light p-3 ">
          <a href="index.php" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
            <span class="navbar-toggler-icon"></span>
          </button>
        <a href="user_dashboard.php" class="btn btn-success ml-auto" >Dashboard</a>
        <a href="userfunc.php?logid=logout" class="btn btn-success ml-3" >Log OUT</a>   
          <!-- <a href="user_dashboard.php?logid=logout" class="btn btn-primary ml-auto mr-5" >Log OUT</a> -->
        </nav>
      </header>


  <div class="btn1">
    <span class="fa fa-bars"></span>
  </div>

  <nav class= "sidebar">
    <a href="#" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>
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
           <li><a href="userfunc.php?updateinfo=updateinfo" id="updateInformation">Update Information</a></li>
          <li><a href="userfunc.php?changepass=changepass" >Change Password</a></li>
        </ul>
      </li> 
    </ul>
  </nav>

  <a href="#" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3" aria-hidden="true"></i><span class="display-5 text-success cab">CedCab</span></a>

  <div id="main">
    <section id="pendingrequest"></section>
    <h1><?php echo "Welcome ".$_SESSION['userdata']['username'] ?></h1> 
    <?php if(isset($_GET['pendingrides']) && $_GET['pendingrides'] == 'pendingrides'){  ?>
     <?php if(isset($_SESSION['userdata'])){ ?>
            <!-- <li class="nav-item">
              <a href="user_dashboard.php" class="btn btn-primary">User Dashboard</a>
            </li> -->
    <?php } ?>
                   
     <section id="request">
      <h2 class="text-center mb-5">Pending Rides</h2>
        <label for="">Sort</label>
        <select class="sortUserPendingRide" >
          <option value="">select</option>
          <option value="descride_date">By Ride Date In DESC Order</option>
          <option value="ascride_date">By Ride Date In ASC Order</option>
          <option value="desctotal_fare">By Fare In DESC Order</option>
          <option value="asctotal_fare">By Fare In ASC Order</option>
        </select>
        <label for="">Filter</label>
          <select class="filterUserPendingRide" >
            <option value="">select</option>
            <option value="week">Last Week</option>
          <option value="month">Last Month</option>
          <option value="cedSUV">Ced SUV</option>
          <option value="cedMicro">Ced Micro</option>
          <option value="cedMini">Ced Mini</option>
          <option value="cedRoyal">Ced Royal</option>
          </select>
          <a href="userfunc.php?pendingrides=pendingrides" class="btn btn-danger " >Clear Filter</a>
           <div id="allRideResult"></div>
        <table id="userAllRide" class="table table-bordered ml-5 mr-5">
          <tr>
            <th>Sr.No. </th>
            <th>Ride Date</th>
            <th>Pickup Location</th>
            <th>Drop Location</th>
            <th>CabType</th>
            <th>Distance Travelled</th>
            <th>Luggage</th>
            <th>Total Fare</th>
            <th>Status</th>
             <th>Cancel Ride</th>
          </tr>
          <?php
          $i = 1;
           foreach($pendingrides as $row) { ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $row['ride_date'] ?></td>
              <td><?php echo $row['pickup'] ?></td>
              <td><?php echo $row['dropup'] ?></td>
              <td><?php echo $row['cab'] ?></td>
              <td><?php echo $row['total_distance'] ?></td>
              <td><?php echo $row['luggage'] ?></td>
              <td><?php echo $row['total_fare'] ?></td>
              <td><?php if ($row['status'] == 1) {echo "Pending";}  ?></td>
              <td><a href="userfunc.php?deleteid= <?php echo $row['ride_id']?> & action=delete" title="Delete"><i class="fa fa-trash ml-4 h4" aria-hidden="true" onclick= "checkdelete()"></i></a></td>
              
            </tr>

          <?php } ?>
          </table>

    </section>
      
      <?php } ?>


      <?php if(isset($_GET['completedrides']) && $_GET['completedrides'] == 'completedrides'){  ?>
        <h2 class="text-center mb-5">Completed Rides</h2>
         <section id="request">
            <section id="request">
            <label for="">Sort</label>
            <select class="sortUserCompletedRide" >
              <option value="">select</option>
              <option value="descride_date">By Ride Date In DESC Order</option>
              <option value="ascride_date">By Ride Date In ASC Order</option>
              <option value="desctotal_fare">By Fare In DESC Order</option>
              <option value="asctotal_fare">By Fare In ASC Order</option>
              </select>
            <label for="">Filter</label>
              <select class="filterUserCompletedRide" >
              <option value="">select</option>
              <option value="week">Last Week</option>
              <option value="month">Last Month</option>
              <option value="cedSUV">Ced SUV</option>
              <option value="cedMicro">Ced Micro</option>
              <option value="cedMini">Ced Mini</option>
              <option value="cedRoyal">Ced Royal</option>
              </select>
               <a href="userfunc.php?completedrides=completedrides" class="btn btn-danger " >Clear Filter</a>
               <div id="allRideResult"></div>
            <table id="userAllRide" class="table table-bordered ml-5 mr-5">
              <tr>
                <th>Sr.No. </th>
                <th>Ride Date</th>
                <th>Pickup Location</th>
                <th>Drop Location</th>
                 <th>CabType</th>
                  <th>Distance Travelled</th>
                  <th>Luggage</th>
                  <th>Total Fare</th>
                  <th>Status</th>
              </tr>
              <?php
              $i = 1;
               foreach($completedrides as $row) { ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row['ride_date'] ?></td>
                  <td><?php echo $row['pickup'] ?></td>
                  <td><?php echo $row['dropup'] ?></td>
                   <td><?php echo $row['cab'] ?></td>
                  <td><?php echo $row['total_distance'] ?></td>
                  <td><?php echo $row['luggage'] ?></td>
                  <td><?php echo $row['total_fare'] ?></td>
                 <td><?php if ($row['status'] == 2) {echo "Completed";}  ?></td>
                </tr>

              <?php } ?>
              </table>
        </section>
      <?php } ?>
      </div>
      
      <?php if(isset($_GET['cancelledrides']) && $_GET['cancelledrides'] == 'cancelledrides'){  ?>
        <h2 class="text-center mb-5">Cancelled Rides</h2>
         <section id="request">
            <section id="request">
            <section id="request">
            <label for="">Sort</label>
            <select class="sortUserCancelledRide" >
              <option value="">select</option>
              <option value="descride_date">By Ride Date In DESC Order</option>
              <option value="ascride_date">By Ride Date In ASC Order</option>
              <option value="desctotal_fare">By Fare In DESC Order</option>
              <option value="asctotal_fare">By Fare In ASC Order</option>
              </select>
            <label for="">Filter</label>
              <select class="filterUserCancelledRide" >
              <option value="">select</option>
              <option value="week">Last Week</option>
              <option value="month">Last Month</option>
              <option value="cedSUV">Ced SUV</option>
              <option value="cedMicro">Ced Micro</option>
              <option value="cedMini">Ced Mini</option>
              <option value="cedRoyal">Ced Royal</option>
              </select>
              <a href="userfunc.php?cancelledrides=cancelledrides" class="btn btn-danger " >Clear Filter</a>
               <div id="allRideResult"></div>
            <table id="userAllRide" class="table table-bordered ml-5 mr-5">
              <tr>
                <th>Sr.No. </th>
                <th>Ride Date</th>
                <th>Pickup Location</th>
                <th>Drop Location</th>
                   <th>CabType</th>
                  <th>Distance Travelled</th>
                  <th>Luggage</th>
                  <th>Total Fare</th>
                  <th>Status</th>
              </tr>
              <?php
              $i = 1;
               foreach($cancelledrides as $row) { ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row['ride_date'] ?></td>
                  <td><?php echo $row['pickup'] ?></td>
                  <td><?php echo $row['dropup'] ?></td>
                   <td><?php echo $row['cab'] ?></td>
                  <td><?php echo $row['total_distance'] ?></td>
                  <td><?php echo $row['luggage'] ?></td>
                  <td><?php echo $row['total_fare'] ?></td>
                  <td><?php if($row['status'] == 0) { echo "Cancelled";}  ?></td>
                </tr>

              <?php } ?>
              </table>
        </section>
      <?php } ?>

      <?php if(isset($_GET['allrides']) && $_GET['allrides'] == 'allrides'){  ?>
         <h2 class="text-center mb-5" >All Rides</h2> 
         <section id="request">
         <label for="">Sort</label>
          <select class="sortUserAllRide" >
            <option value="">select</option>
            <option value="descride_date">By Ride Date In DESC Order</option>
          <option value="ascride_date">By Ride Date In ASC Order</option>
          <option value="desctotal_fare">By Fare In DESC Order</option>
          <option value="asctotal_fare">By Fare In ASC Order</option>
            </select>
          <label for="">Filter</label>
            <select class="filterAllRide" >
            <option value="">select</option>
              <option value="week">Last Week</option>
              <option value="month">Last Month</option>
              <option value="cedSUV">Ced SUV</option>
              <option value="cedMicro">Ced Micro</option>
              <option value="cedMini">Ced Mini</option>
              <option value="cedRoyal">Ced Royal</option>
            </select>
            <a href="userfunc.php?allrides=allrides" class="btn btn-danger " >Clear Filter</a>
          <div id="allRideResult"></div>
            <table id="userAllRide" class="table table-bordered ml-5 mr-5">
              <tr>
                <th>Sr.No. </th>
                <th>Ride Date</th>
                <th>Pickup Location</th>
                <th>Drop Location</th>
                 <th>Cab Type</th>
                  <th>Distance Travelled</th>
                  <th>Luggage</th>
                  <th>Total Fare</th>
                  <th>Status</th>
              </tr>
              <?php
              $i = 1;
               foreach($allrides as $row) { ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row['ride_date'] ?></td>
                  <td><?php echo $row['pickup'] ?></td>
                  <td><?php echo $row['dropup'] ?></td>
                     <td><?php echo $row['cab'] ?></td>
                  <td><?php echo $row['total_distance'] ?></td>
                  <td><?php echo $row['luggage'] ?></td>
                  <td><?php echo $row['total_fare'] ?></td>
                 <td><?php if ($row['status'] == 1) {echo "Pending";}  
                  else if($row['status'] == 0){echo "Cancelled"; }
                  else {echo "Completed";}
                  ?></td>
                </tr>

              <?php } ?>
              </table>
        </section>
      <?php } ?>

      <?php if(isset($_GET['updateinfo']) && $_GET['updateinfo'] == 'updateinfo'){  ?>
        <center><h4>Update Your Info</h4></center>
        <div class="container">
          <div class="row">
            <div class="col-lg-8">

              <form method="post">
                <input type="hidden" name="id" value="<?php echo $data['user_id']; ?>">
                <div class="form-group" >
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" onkeypress="return onlytext()" value="<?php echo $data['name']; ?>" placeholder="Enter name">
                </div>
                <div class="form-group">
                  <label for="mobile">Mobile No.</label>
                  <input type="text" class="form-control" name="mobile" value="<?php echo $data['mobile']; ?>" placeholder="Enter your no.">
                  <!-- <input type="tel" class="form-control"  name="mobile" value="<?php echo $data['mobile']; ?>" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="Enter your no."> -->
                  <!-- type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" -->
                </div>
                
                <input type="submit" class="btn btn-primary" name="updateinfo" value="Submit">
              </form>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($_GET['changepass']) && $_GET['changepass'] == 'changepass'){  ?>
        <h2 class="text-center">Change Your Password</h2>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 ">

              <form>
                <div class="form-group">
                  <label for="oldpass">Old Password</label>
                  <input type="password" class="form-control" id="oldpass" aria-describedby="emailHelp" placeholder="Enter old password">
                </div>
                <div class="form-group">
                  <label for="newpass">New Password</label>
                  <input type="password" class="form-control" id="newpass" placeholder="New Password">
                </div>
                <div class="form-group">
                  <label for="mobile">Confirm Password</label>
                  <input type="password" class="form-control" id="repass" placeholder="Confirmation Password">
                </div>
                
                <button type="submit" class="btn btn-primary" id="changepassword">Submit</button>
              </form>
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




 <!-- if(isset($_POST['sortData'])){
    $sort = @$_POST['sort_dropdown'];
    if ($sort!="Choose..") 
    { 
      echo "<table>";
      $sortQuery="SELECT * FROM `tbl_ride` ORDER BY `".$sort."` ";
      $sort=mysqli_query($db->conn, $sortQuery);
      while ($row = mysqli_fetch_array($sort))
      {
        echo "<tr>";
        echo "<td>".$row['ride_id']."</td>";
            echo "<td>".$row['ride_date']."</td>";
            echo "<td>".$row['from']."</td>";
            echo "<td>".$row['to']."</td>";
            echo "<td>".$row['total_distance']."</td>";
            echo "<td>".$row['luggage']."</td>";
            echo "<td>".$row['total_fare']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "<td>".$row['customer_user_id']."</td>";
        echo "</tr>";
 -->