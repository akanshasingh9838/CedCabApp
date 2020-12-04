<?php
Class User{
	public $user_id;
	public $user_name;
	public $name;
	public $dateofsignup;
	public $mobile;
	public $isblock;
	public $password;
	public $isadmin;
	public $result;
	public $message;
	public $errors;
	public $approveRowcount;

	function login($username,$password,$conn){
		$count=0;
		$errors=array();
		if(isset($_SESSION['userdata'])|| isset($_SESSION['admindata'])){
			return "falsee";
		}		
		else{
			$sql = "SELECT * FROM tbl_user WHERE `user_name`='$username' AND `password`= '$password'";
			$this -> result = $conn -> query($sql); 
			if ($this -> result -> num_rows > 0) {
				// output data of each row
			
				while($row = $this -> result->fetch_assoc()) {
					if($row['isadmin'] == "1"){

						$_SESSION['admindata']=array('adminname'=>$row['user_name'],'admin_id'=>$row['user_id']);
						if(isset($_POST['remember'])){
							setcookie('username',$row['user_name'],time()+60*60*7);
						}
					
						echo "<center><h3>Login Successfully</h3></center>" ;
						header('Location: admin/admin_dashboard1.php');
						
					}
					else
					{	
					
						if($row['isblock']=="0"){
							$_SESSION['userdata']=array('username'=>$row['user_name'],'user_id'=>$row['user_id']);
								//to book a ride if login after calculating fare ,and clicked on book fare 
							setcookie('username',$row['user_name'],time()+60*60*7);
								if(isset($_SESSION['ride'])){
									$now = time();
									if ($now < $_SESSION['expire']) {
										return "ride_created";
									} else {
										unset($_SESSION['expire']);
										header('location: index.php');
									}
			
								}
								
							echo "login successfully";
							header('Location: user_dashboard.php');
						}		
						else {
							
							echo "<script> alert('You are blocked by the admin'); </script>";
							$errors[]=array('input'=>'form','msg'=>'Your Request is Pending');		
						}
					}
				}
			} 
			else {
				echo "<script> alert('Invalid Login Details'); </script>";
			}
			
			$conn->close();
		} 
	}

	function signup($user_name,$name,$password,$mobile,$dateofsignup,$conn){
		//check db for existing user with same username or email'	
		$sql = "SELECT * FROM tbl_user WHERE `user_name`='$user_name' LIMIT 1";  // or `email` ='$email'
		$this -> result = $conn->query($sql);

		if ($this-> result->num_rows > 0) {
	
			while($row = $this -> result->fetch_assoc()) {				
				if($row["user_name"]===$user_name){
					// $errors[]=array("input"=>"username","msg"=>"username already exists");
					echo "<center><h3>username already exists</h3></center>";
				}
			}
		}
		
			$sql='INSERT INTO tbl_user(`user_name`,`name`,`password`,`mobile`,`dateofsignup`,`isblock`,`isadmin`)VALUES("'.$user_name.'","'.$name.'","'.$password.'","'.$mobile.'","'.$dateofsignup.'","1","0")';
	        if ($conn->query($sql) === TRUE) {
				// $message="New record created successfully";
				echo "<center><h3>Your request id is pending , Please wait till confirmation..Thank You....</h3></center>";

	        } else {
	            // $errors=array('input'=>'form','msg'=>$conn->error);
	            echo "<center><h3>error sign up fail</h3></center>";
	          
	        }        
	        $conn->close();
	}

	function numPendingRequests($conn){
		$sql = 'SELECT * FROM `tbl_user` WHERE `isblock`= "1" ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}

	function totalusers($conn){
		$sql = 'SELECT * FROM `tbl_user` ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}
	
	function BlockUsers($conn){
	
		$data = array();
		$sql = 'SELECT * FROM `tbl_user` WHERE `isblock`= "1" ';
		$this -> result = $conn -> query($sql); 
	   if ($this -> result->num_rows > 0) {
		 
		  while($row = $this -> result-> fetch_assoc()) {
			$data[] = $row;
		  }
		  return $data;
		} else {
		  return "0 results";
		}
	}

	function allusers($conn){
		$data=array();
		$sql = 'SELECT * FROM `tbl_user` ';
		$this -> result = $conn -> query($sql);
		if($this -> result -> num_rows>0) {
			while($row = $this -> result-> fetch_assoc()) {
			 	$data[] = $row;
			}
		return $data;
		}
		else{
			return "0 results";
		}
	}

	function approvedusers($conn){
		$data=array();
		$sql = 'SELECT * FROM `tbl_user` WHERE `isblock`= "0" ';
		$this -> result = $conn -> query($sql);
		if($this -> result -> num_rows>0) {
			while($row = $this -> result-> fetch_assoc()) {
			 	$data[] = $row;
			}
			$this-> approveRowcount = mysqli_num_rows($this -> result);
		return $data;
		}
		else{
			return "0 results";
		}
	}

	function changePassword($oldpassword,$newpassword,$conn,$uid){
        $sql = "SELECT * FROM `tbl_user` WHERE `user_id` = '$uid' AND `password` = MD5('$oldpassword') ";
        $res = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $sql = "UPDATE `tbl_user` SET `password` = MD5('$newpassword') WHERE `user_id` = '$uid' ";
            if (mysqli_query($conn, $sql)) {
            	return true;
            }
        } else {
           $msg = "center><h3>Incorrent Old Password !</h3></center>";
        }
        return $msg;
	}

	function unblockUser($user_id, $conn)
	{
		$sql = "UPDATE `tbl_user` SET `isblock` = '0' WHERE `user_id` = '$user_id' ";
		if (mysqli_query($conn, $sql)) {
			$msg = "User will be unblocked !";
		} else {
			$msg = "Request Failed !";
		}
		return $msg;
		
	}
	
	function changeInfo($name, $password, $mobile, $user_id,$conn){
		$sql = "UPDATE `tbl_user` SET `name` = '$name' ,`password` ='$password' , `mobile` = 'mobile' WHERE `user_id` = '$user_id' ";
		if (mysqli_query($conn, $sql)) {
			$msg = "True";
		} else {
			$msg = "False";
		}
		return $msg;
	}

	function changeUserPassword($oldpassword,$newpassword,$uid,$conn){
        $sql = "SELECT * FROM `tbl_user` WHERE `user_id` = '$uid' AND `password` = '$oldpassword'";
        $res = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $sql = "UPDATE `tbl_user` SET `password` = '$newpassword' WHERE `user_id` = '$uid' ";
            if (mysqli_query($conn, $sql)) {
            	return true;
            }
        } else {
            $msg = "Incorrent Old Password !";
        }
        return $msg;
	}

	function updateInfoBtn($id,$conn){
		$data=array();
		$sql = "SELECT * from `tbl_user` WHERE  `user_id` = '$id' ";
		$this -> result = $conn -> query($sql);
		if($this -> result -> num_rows > 0) {
			while($row = $this -> result-> fetch_assoc()) {
					$data[] = $row;
			}
		return $data;
		}
	}

	function noPendingUsers($conn){
		$sql = 'SELECT * FROM `tbl_user` WHERE `isblock` = "1" ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}

	function noApprovedUsers($conn){
		$sql = 'SELECT * FROM `tbl_user` WHERE `isblock` = "0" ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}

	function fetchDataUpdate($id, $conn) {
		$sql = "SELECT * FROM `tbl_user` WHERE `user_id` = '$id' ";
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($res);
		return $row;
	}

	function updateUserInfo($name, $mobile, $id, $conn)
	{
		$sql = "UPDATE `tbl_user` SET `name` = '$name', `mobile` = '$mobile' WHERE `user_id` = '$id' ";
		if (mysqli_query($conn, $sql)) {
			$msg = "Sucessfully Update Your Information !";
		}
		return $msg;
	}

	function sortPendingUsersName($data, $conn) {
		$row = array();
        if ($data == 'usernameAsc') {
            $sql = "SELECT * FROM `tbl_user` WHERE `isblock` = '1' ORDER BY `name`  ";
        } 
        else {
            $sql = "SELECT * FROM `tbl_user` WHERE `isblock` = '1' ORDER BY `name` DESC ";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
        echo $data;
	}


	function sortApprovedUsersName($data, $conn) {
		$row = array();
        if ($data == 'usernameAsc') {
            $sql = "SELECT * FROM `tbl_user` WHERE `isblock` = '0' ORDER BY `name`  ";
        } 
        else {
            $sql = "SELECT * FROM `tbl_user` WHERE `isblock` = '0' ORDER BY `name` DESC ";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
        echo $data;
	}

	function sortAllUsersName($data, $conn) {
		$row = array();
        if ($data == 'usernameAsc') {
            $sql = "SELECT * FROM `tbl_user` ORDER BY `name`  ";
        } 
        else {
            $sql = "SELECT * FROM `tbl_user`  ORDER BY `name` DESC ";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
        echo $data;
	}

}



?>