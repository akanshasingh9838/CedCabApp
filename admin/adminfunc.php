<?php
session_start();
require('../classes.php');
require('../config.php');
require('../location_classes.php');
require('../ride.php');
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
$location =  new location();
$rideobj =  new Ride();

if(isset($_GET['pendingrequest']) && $_GET['pendingrequest'] == 'pendingrequest'){  
  $blockusers =$numrequest -> BlockUsers($dbcon-> conn);
}
if(isset($_GET['alluser']) && $_GET['alluser'] == 'alluser'){  
  $allusers =$numrequest -> allusers($dbcon-> conn);
}
if(isset($_GET['approveduser']) && $_GET['approveduser'] == 'approveduser'){  
  $approvedusers =$numrequest -> approvedusers($dbcon-> conn);
}
if(isset($_GET['location']) && $_GET['location'] == 'location'){  
  $all_location =$location -> allLocation($dbcon-> conn);
}
if(isset($_GET['allrides']) && $_GET['allrides'] == 'allrides'){  
  $allrides =$rideobj -> allRide($dbcon-> conn);
}

if(isset($_POST['submit'])){
	$lname= $_POST['lname'];
	$dist=$_POST['dist'];
	$msg = $location-> addLocation($lname,$dist,$dbcon-> conn);
	echo $msg;
}	
if(isset($_GET['pendingrides']) && $_GET['pendingrides'] == 'pendingrides'){  
  $pendingrides =$rideobj -> pendingRide($dbcon-> conn);
}
if(isset($_GET['completedrides']) && $_GET['completedrides'] == 'completedrides'){  
  $completedrides =$rideobj -> completedRide($dbcon-> conn);
}
if(isset($_GET['cancelledrides']) && $_GET['cancelledrides'] == 'cancelledrides'){  
  $cancelledrides =$rideobj -> cancelledRide($dbcon-> conn);
}

if(isset($_GET['name']) && $_GET['action'] == 'edit'){  
  echo $_GET['name'];
  echo $_GET['action'];
}

if(isset($_GET['deleteid']) && $_GET['action'] == 'delete'){  
	$loc = $_GET['deleteid'];
  $location-> deleteLocation($loc ,$dbcon-> conn);
  header('Location:adminfunc.php?location=location');
}
if(isset($_POST['changepass'])){
  $numrequest-> changePassword($dbcon-> conn);
}
if(isset($_GET['invoice']) && $_GET['invoice'] == 'invoice'){  
	$id=$_GET['invoiceid'];
  $invoice =$rideobj -> InvoicePrint($dbcon-> conn , $id);
}
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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="adminScript.js"></script>
	  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
	<div class="btn1">
		<span class="fa fa-bars"></span>
	</div>
	
	<nav class= "sidebar">
		<a href="../index.php" class="navbar-brand display-4 mt-3 mb-5 pl-5"><i class="fa fa-taxi h2 mr-3" aria-hidden="true"></i><span class=" text-primary h2 cab">CedCab</span></a>

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
		<a href="../index.php" class="navbar-brand pl-5"><i class="fa fa-taxi mr-3 h2 " aria-hidden="true"></i><span class="h2 text-primary cab">CedCab</span></a>
	  	<a href="admin_dashboard1.php" class="btn btn-primary float-right mr-5 mt-3" >Dashboard</a>
	  	<a href="admin_dashboard1.php?logid=logout" class="btn btn-primary float-right mr-5 mt-3" >Log OUT</a>

	<div id="main">
	 <h1 class="text-center"><?php echo "Welcome " .$_SESSION['admindata']['adminname'] ?> in  Admin Panel
	<!--  <a href="admin_dashboard1.php" class="btn btn-primary float-right mr-5" >Dashboard</a>
	  <a href="admin_dashboard1.php?logid=logout" class="btn btn-primary float-right mr-5" >Log OUT</a> -->
	</h1>
	  
		<p id="result"></p>
	<?php if(isset($_GET['pendingrequest']) && $_GET['pendingrequest'] == 'pendingrequest'){  ?>
		<h2 class="text-center mb-5" >Pending Users</h2>
	   	<section id="request">
	   		<label for="">Sort</label>
			<select class="sortPendingUsersName">
			  <option value="">select</option>
			  <option value="usernameAsc">By Username (Ascending Order)</option>
			  <option value="usernameDsc">By Username (Descending Order)</option>
			  </select>
		    <table id="allRideResult" class="table table-bordered ml-5 mr-5">
	        <tr>
	          <th>Sr.No. </th>
	          <th>User_Name </th>
	          <th>Date</th>
	          <th>Action</th>
	        </tr>
	        <?php
	        $i = 1;
	         foreach($blockusers as $row) { ?>
	          <tr>
	            <td><?php echo $i++; ?></td>
	            <td><?php echo $row['user_name'] ?></td>
	            <td><?php echo $row['dateofsignup'] ?></td>
	            <td>
					<button type="button" class="unblock" data-id = <?php echo $row['user_id']; ?> >Unblock </button>
				</td>
				
	          </tr>
	        <?php } ?>
	      	</table>
		</section>
	<?php } ?>

	<?php if(isset($_GET['alluser']) && $_GET['alluser'] == 'alluser'){  ?>
		<h2 class="text-center mb-5" >All Users</h2>
  		<section id="request"> 	
  			<label for="">Sort</label>
			<select class="sortAllUsersName">
			  <option value="">select</option>
			  <option value="usernameAsc">By Username (Ascending Order)</option>
			  <option value="usernameDsc">By Username (Descending Order)</option>
			  </select>
		    <table id="allRideResult" class="table table-bordered ml-5 mr-5">					
	        <tr>
	          <th>Sr.No. </th>
	          <th>User_ID </th>
	          <th>User Name</th>
	          <th>Name</th>
	          <th>Date Of Signup</th>
	          <th>Mobile</th>
	          <th>Is Block</th>
	          <th>Is Admin</th>			
	        </tr>
	        <?php
	        $i = 1;
	         foreach($allusers as $row) { ?>
	          <tr>
	            <td><?php echo $i++; ?></td>
	            <td><?php echo $row['user_id'] ?></td>
	            <td><?php echo $row['user_name'] ?></td>
	            <td><?php echo $row['name'] ?></td>
	            <td><?php echo $row['dateofsignup'] ?></td>
	            <td><?php echo $row['mobile'] ?></td>
	            <!-- <td><?php //echo $row['isblock'] ?></td> -->
	            <td><?php if ($row['isblock'] == 1) {echo "Blocked";}  
	              else {echo "Completed";}
	              ?></td>
	              <td><?php if ($row['isadmin'] == 1) {echo "Admin";}  
	              else {echo "User";}
	              ?></td>	      
	          </tr>
	        <?php } ?>
	      	</table>
		</section>
	<?php } ?>

	<?php if(isset($_GET['approveduser']) && $_GET['approveduser'] == 'approveduser'){  ?>
		<h2 class="text-center mb-5" >Approved Users</h2>
  		<section id="request">
  			<label for="">Sort</label>
			<select class="sortApprovedUsersName">
			  <option value="">select</option>
			  <option value="usernameAsc">By Username (Ascending Order)</option>
			  <option value="usernameDsc">By Username (Descending Order)</option>
			  </select>
		    <table id="allRideResult" class="table table-bordered ml-5 mr-5">				    
	        <tr>
	          <th>Sr.No. </th>
	          <th>User_Name </th>
	          <th>Date</th>
	          <th>isblock</th>
	        </tr>
	        <?php
	        $i = 1;
	         foreach($approvedusers as $row) { ?>
	          <tr>
	            <td><?php echo $i++; ?></td>
	            <td><?php echo $row['user_name'] ?></td>
	            <td><?php echo $row['dateofsignup'] ?></td>
	            <td><?php if ($row['isblock'] == 0) {echo "Not Blocked";}  ?></td>
	          </tr>

	        <?php } ?>
	      	</table>
		</section>
	<?php } ?>

	<?php if(isset($_GET['location']) && $_GET['location'] == 'location'){  ?>
	  		<h2 class="text-center">Locations</h2>
	  		<section id="request">	
		    <table class="table table-bordered ml-5 mr-5">
	        <tr>
	          <th>Sr.No. </th>
	          <th>Name </th>
	          <th>Distance</th>
	          <th>Is Available</th>
	          <th>Action </th>
	        </tr>
	        <?php
	        $i = 1;
	         foreach($all_location  as $row) { ?>
	          <tr>
	            <td><?php echo $i++; ?></td>
	            <td><?php echo $row['name'] ?></td>
	            <td><?php echo $row['distance'] ?></td>
	            <td><?php echo $row['is_available'] ?></td>
	            <td>
            	<button type="button" data-id="<?php echo $row['id']; ?>" class="btn-primary mr-4 ml-4 editloc" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
	            <a href="adminfunc.php?deleteid= <?php echo $row['id']?> & action=delete" title="Delete"><i class="fa fa-trash" aria-hidden="true" onclick= "checkdelete()"></i></a>
	        	</td>
	          </tr>
	        <?php } ?>
	      	</table>
	      </section>

			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Location Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
					<div class="form-group">
						<label for="Location-name" class="col-form-label">Location Name:</label>
						<input type="text" class="form-control" id="loc-name">
					</div>
					<div class="form-group">
						<label for="Location-name" class="col-form-label">Location Distance:</label>
						<input type="text" class="form-control" id="loc-dist">
					</div>
					<input type="hidden" id="locid">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" id="updateloc" class="btn btn-primary">Update Location</button>
				</div>
				</div>
			</div>
			</div>

		
	<?php } ?>

	<?php if(isset($_GET['addlocation']) && $_GET['addlocation'] == 'addlocation'){ ?> 
		<h2>ADD YOUR LOCATION</h2>
		<section id="form">
		    <div class="container">
		    	
		  <form action="" method="post"> 
 			  <div class="row">
			    <div class="col-25">
			      <label for="fname">Location Name</label>
			    </div>
			    <div class="col-75">
			      <input type="text" id="lname" name="lname" placeholder="Location name..">
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-25">
			      <label for="lname">Location Distance</label>
			    </div>
			    <div class="col-75">
			      <input type="text" id="dist" name="dist" placeholder="Distance from charbagh..">
			    </div>
			  </div>
			  <div class="row">
			    <input type="submit" value="Add Location" name="submit">
			  </div>
			  </form>
			</div>
		</section>
	<?php } ?>

	<?php if(isset($_GET['pendingrides']) && $_GET['pendingrides'] == 'pendingrides'){  ?>
		<h2 class="text-center mb-5" >Pending RIDES</h2>
		 <section id="request">
		 	
		 <label for="">Sort</label>
			<select class="sortPendingRide" >
			  <option value="">select</option>
			  <option value="ride_date">By Ride Date</option>
			  <option value="total_fare">By Fare</option>
			  </select>
			<label for="">Filter</label>
			  <select class="filterPendingRide" >
			  <option value="">select</option>
			  <option value="week">Last Week</option>
			  <option value="month">Last Month</option>
		  	</select>
		 <div id="allRideResult"></div>
		    <table id="allRide" class="table table-bordered ml-5 mr-5">
	        <tr>
	          <th>Sr.No. </th>
	          <th>Ride Date</th>
	          <th>Pickup Location</th>
	          <th>Drop Location</th>
              <th>Distance Travelled</th>
              <th>Luggage</th>
              <th>Total Fare</th>
              <th>Status</th>
			  <th>Action</th>
	        </tr>
	        <?php
	        $i = 1;
	         foreach($pendingrides as $row) { ?>
	          <tr>
	            <td><?php echo $i++; ?></td>
	            <td><?php echo $row['ride_date'] ?></td>
	            <td><?php echo $row['pickup'] ?></td>
	            <td><?php echo $row['dropup'] ?></td>
	            <td><?php echo $row['total_distance'] ?></td>
	            <td><?php echo $row['luggage'] ?></td>
	            <td><?php echo $row['total_fare'] ?></td>
	            <td><?php if ($row['status'] == 1) {echo "Pending";}  ?></td>
				<td><button class='approve' data-id="<?php echo $row['ride_id']; ?>" type="button" >Approve</button>
				<button class ='cancel' data-id="<?php echo $row['ride_id']; ?>" type="button" >Cancel</button>
				<button class ="delete" type="button" data-id="<?php echo $row['ride_id']; ?>">Delete</button></td>
	          </tr>

	        <?php } ?>
	      	</table>
		</section>
	<?php } ?>

	<?php if(isset($_GET['completedrides']) && $_GET['completedrides'] == 'completedrides'){  ?>
		<h2 class="text-center mb-5" >COMPLETED RIDES</h2>
	   <section id="request">
	   		
		 <label for="">Sort</label>
			<select class="sortCompletedRide" >
			  <option value="">select</option>
			  <option value="ride_date">By Ride Date</option>
			  <option value="total_fare">By Fare</option>
			  </select>
			<label for="">Filter</label>
			  <select class="filterPendingRide" >
			  <option value="">select</option>
			  <option value="week">Last Week</option>
			  <option value="month">Last Month</option>
		  	</select>
		 <div id="allRideResult"></div>
		    <table id="allRide" class="table table-bordered ml-5 mr-5">
	        <tr>
	          <th>Sr.No. </th>
	          <th>Ride Date</th>
	          <th>Pickup Location</th>
	          <th>Drop Location</th>
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
	            <td><?php echo $row['total_distance'] ?></td>
	            <td><?php echo $row['luggage'] ?></td>
	            <td><?php echo $row['total_fare'] ?></td>
	             <td><?php if ($row['status'] == 2) {echo "Completed";}  ?></td>
	            
	          </tr>
	        <?php } ?>
	      	</table>
		</section>
	<?php } ?>

	<?php if(isset($_GET['cancelledrides']) && $_GET['cancelledrides'] == 'cancelledrides'){  ?>
		<h2 class="text-center mb-5" >CANCELLED RIDES</h2>
	   <section id="request">
	   		
	   	 <section id="request">
		 <label for="">Sort</label>
			<select class="sortCancelledRide" >
			  <option value="">select</option>
			  <option value="ride_date">By Ride Date</option>
			  <option value="total_fare">By Fare</option>
			  </select>
			<!-- <label for="">Filter</label>
			  <select class="filterPendingRide" >
			  <option value="">select</option>
			  <option value="week">Last Week</option>
			  <option value="month">Last Month</option>
		  	</select> -->
		 <div id="allRideResult"></div>
		    <table id="allRide" class="table table-bordered ml-5 mr-5">
	        <tr>
	          <th>Sr.No. </th>
	          <th>Ride Date</th>
	          <th>Pickup Location</th>
	          <th>Drop Location</th>
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
	            <td><?php echo $row['total_distance'] ?></td>
	            <td><?php echo $row['luggage'] ?></td>
	            <td><?php echo $row['total_fare'] ?></td>
	            <td><?php if ($row['status'] == 0) {echo "Cancelled";}  ?></td>
	          </tr>

	        <?php } ?>
	      	</table>
		</section>
	<?php } ?>

	<?php if(isset($_GET['allrides']) && $_GET['allrides'] == 'allrides'){  ?>
	<h2 class="text-center mb-5" >ALL RIDES</h2>
     <section id="request">
     		
	 <label for="">Sort</label>
		<select class="sortAllRide" >
		  <option value="">select</option>
		  <option value="ride_date">By Ride Date</option>
		  <option value="total_fare">By Fare</option>
		  </select>
		<label for="">Filter</label>
		  <select class="filterAllRide" >
		  <option value="">select</option>
		  <option value="week">Last Week</option>
		  <option value="month">Last Month</option>
	  	</select>
		 <div id="allRideResult"></div>
        <table  id="allRide" class="table table-bordered ml-5 mr-5">
          <tr>
            <th>Sr.No. </th>
            <th>Ride Date</th>
            <th>Pickup Location</th>
            <th>Drop Location</th>
              <th>Distance Travelled</th>
              <th>Luggage</th>
              <th>Total Fare</th>
              <th>Status</th>
              <th>Invoice</th>
          </tr>
          <?php
          $i = 1;
           foreach($allrides as $row) { ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $row['ride_date'] ?></td>
              <td><?php echo $row['pickup'] ?></td>
              <td><?php echo $row['dropup'] ?></td>
              <td><?php echo $row['total_distance'] ?></td>
              <td><?php echo $row['luggage'] ?></td>
              <td><?php echo $row['total_fare'] ?></td>
              <td><?php if ($row['status'] == 1) {echo "Pending";}  
              else if($row['status'] == 0){echo "Cancelled"; }
              else {echo "Completed";}
              ?></td>
              <td><a href ="adminfunc.php?invoiceid= <?php echo $row['ride_id'] ?>& invoice=invoice">Check Invoice</a> </td>
            </tr>

          <?php } ?>
          </table>
    </section>
  <?php } ?>

  <?php if(isset($_GET['changepass']) && $_GET['changepass'] == 'changepass'){ ?> 
  		<h2 class="text-center ">CHANGE YOUR PASSWORD</h2>
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
				<form>
				<div class="form-group">
					<label for="oldpass">Old Password </label>
					<input type="password" class="form-control" id="oldpass" aria-describedby="emailHelp" placeholder="Enter Old Password">
				</div>
				<div class="form-group">
					<label for="newpass">New Password</label>
					<input type="password" class="form-control" id="newpass" placeholder="Enter New Password">
				</div>
				<div class="form-group">
					<label for="repass">Re Password</label>
					<input type="password" class="form-control" id="repass" placeholder="Enter New Password Again">
				</div>
				<button type="submit" class="btn btn-primary" id ="changepass" >Change Password</button>
				</form>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php 
	if(isset($_GET['invoice']) && $_GET['invoice'] == 'invoice'){  ?>
		<div class= "container text-center">
			<h2>USER INVOICE</h2>
			<div class="row text-center">
				<div class="col-lg-6">
					<!-- <p><?php //echo $invoice[0]['pickup']; ?></p> -->
					<section id="request">
					    <table class="table table-bordered ml-5 mr-5">
				        <tr><th>Pickup Location </th><td><?php echo $invoice[0]['pickup'] ?></td> </tr>
				        <tr><th>Drop Location</th><td><?php echo $invoice[0]['dropup'] ?></td></tr>
				        <tr> <th>Ride Date</th><td><?php echo $invoice[0]['ride_date'] ?></td></tr>
				        <tr><th>Luggage</th><td><?php echo $invoice[0]['luggage'] ?></td>	</tr>
				      			          
				        <tr> <th>Distance Travelled</th><td><?php echo $invoice[0]['total_distance'] ?></td></tr>
				      
				        <tr><th>Fare</th><td><?php echo $invoice[0]['total_fare'] ?></td></tr>
				   				   			      
   					    </table>

					</section>
					<center><button class="btn btn-success ml-5 mt-5" onclick="window.print()">Print Invoice</button><center>					
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
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
 <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>