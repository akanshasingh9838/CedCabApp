<?php
class Ride{
	public $from;
	public $to;
	public $totaldistance;
	public $luggage;
	public $totalfare;
	public $status;
	public $userid;
	public $conn;
	public $res;


	function insertBookDetails($conn){
		$ridedate = date('Y-m-d');
		$sql='INSERT INTO tbl_ride(`ride_date`,`pickup`,`dropup`,`cab`,`total_distance`,`luggage`,`total_fare`,`status`,`customer_user_id`)VALUES("'.$ridedate.'","'.$_SESSION['ride']['pickup'].'","'.$_SESSION['ride']['dropup'].'","'.$_SESSION['ride']['cab'].'","'.$_SESSION['ride']['distance'].'","'.$_SESSION['ride']['luggage'].'","'. $_SESSION['ride']['fare'].'","1","'.$_SESSION['userdata']['user_id'].'")';
		
        if ($conn->query($sql) === TRUE) {
			return "Your Ride is Pending";

        } else {
  
            echo "There is some error in booking your ride";
            return "Error: " . $sql . "<br>" . $conn->error;
        }        
        // $conn->close();
	}

	function pendingRide($conn){
		$row = array();
        $sql = "SELECT * FROM `tbl_ride` WHERE `status` = '1' ";
        $res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
    }

	function completedRide($conn){
		$row=array();
		$sql="SELECT * from `tbl_ride` WHERE `status` = '2' ";
		$res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
	}

	function cancelledRide($conn){
		$row=array();
		$sql="SELECT * from `tbl_ride` WHERE `status` = '0' ";
		$res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
	}

	function allRide($conn){
		$row=array();
		$sql="SELECT * from `tbl_ride` ";
		$res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
	}

	function userPendingRide($conn){
		$row = array();
	    $sql = 'SELECT * FROM `tbl_ride` WHERE `status`= "1" and `customer_user_id`= "'.$_SESSION['userdata']['user_id'].'"';
	    $this-> res = mysqli_query($conn, $sql);                                   
	    while($data = mysqli_fetch_assoc($this-> res))
	    {
	        $row[] = $data;
	    }
	    return $row;
	}

	function userCompletedRide($conn){
		$row=array();
		$sql='SELECT * from `tbl_ride` WHERE `status` = "2" and `customer_user_id`= "'.$_SESSION['userdata']['user_id'].'"';
		$res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
	}

	function userCancelledRide($conn){
		$row=array();
		$sql='SELECT * from `tbl_ride` WHERE `status` = "0" and `customer_user_id`= "'.$_SESSION['userdata']['user_id'].'"';
		$res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
	}

	function userAllRide($conn){
		$row=array();
		$sql='SELECT * from `tbl_ride` WHERE `customer_user_id`= "'.$_SESSION['userdata']['user_id'].'"';
		$res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
	}

	function approveRide($ride_id, $conn)
	{
		$sql = "UPDATE `tbl_ride` SET `status` = '2' WHERE `ride_id` = '$ride_id' ";
		if (mysqli_query($conn, $sql)) {
			$msg = "Approved Sucess !";
		} else {
			$msg = "Approved Faild !";
		}
		return $msg;
		
	}

	function cancelRide($ride_id, $conn)
	{
		$sql = "UPDATE `tbl_ride` SET `status` = '0' WHERE `ride_id` = '$ride_id' ";
		if (mysqli_query($conn, $sql)) {
			$msg = "Ride would be cancelled !";
		} else {
			$msg = "Cancel Faild !";
		}
		return $msg;
		
	}

	function deleteRide($ride_id, $conn)
	{
		// sql to delete a record
		$sql = "DELETE FROM `tbl_ride` WHERE `ride_id` = '$ride_id' ";

		if ($conn->query($sql) === TRUE) {
		echo "Ride would be deleted";
		} else {
		echo "Error deleting record: " . $conn->error;
		}

		
	}

	function Totalexpenditure($conn){
		$sql ="SELECT SUM(`total_fare`)
		FROM `tbl_ride`";
		$result= mysqli_query($conn,$sql);
		$row= mysqli_fetch_row($result);
		return $row;

	}

	function sortAllRide($data, $conn) {
		$row = array();
        if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride` ORDER BY `ride_date` DESC ";
        } else if ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride` ORDER BY `ride_date` ASC ";
        } else if ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` ORDER BY `total_fare` DESC ";
        } else if ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride`";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function fetchFilterRide($sdata, $conn)
	{
		$row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' ";
        } else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id'";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function sortUserAllRide($data, $conn, $id) {
		$row = array();
        if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' ORDER BY `ride_date` DESC ";
        } else if ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' ORDER BY `ride_date` ASC ";
        } else if ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' ORDER BY `total_fare` DESC ";
        } else if ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id'";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function totalrides($conn){
		$sql = 'SELECT * FROM `tbl_user` ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}

	function noPendingRides($conn){
		$sql = 'SELECT * FROM `tbl_ride` WHERE 	`status` ="1" ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}

	function noCompletedRides($conn){
		$sql = 'SELECT * FROM `tbl_ride` WHERE 	`status` ="2" ';
		$this -> result = $conn -> query($sql); 
	    $rowcount=mysqli_num_rows($this -> result);
	    return $rowcount;	
	}

	function fetchUserFilterRide($sdata, $conn, $id)
	{
		$row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY) and `customer_user_id` = '$id' ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
			$sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) and `customer_user_id` = '$id' ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' and `customer_user_id` = '$id' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' and `customer_user_id` = '$id' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' and `customer_user_id` = '$id' ";
        } else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro' and `customer_user_id` = '$id' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id'";
        }


        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function sortUserPendingRide($data, $conn,$id) {
		$row = array();
        if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `customer_user_id` = '$id' and `status`= '1' ORDER BY `ride_date` DESC  ";
        } else if ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `customer_user_id` = '$id' and `status`= '1' ORDER BY `ride_date` ASC  ";
        } else if  ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `customer_user_id` = '$id' and `status`= '1' ORDER BY `total_fare` DESC ";
        } else if ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `customer_user_id` = '$id' and `status`= '1' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `customer_user_id` = '$id' and `status`= '1' ";   
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function filterUserPendingRide($sdata, $conn, $id)
	{
		$row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY) and `customer_user_id` = '$id' and `status`='1' ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
			$sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) and `customer_user_id` = '$id' and `status`='1' ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' and `customer_user_id` = '$id' and `status`='1' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' and `customer_user_id` = '$id' and `status`='1' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' and `customer_user_id` = '$id' and `status`='1' ";
        } else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro' and `customer_user_id` = '$id' and `status`='1' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`='1' ";
        }
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function sortUserCompletedRide($data, $conn, $id) {
		$row = array();
        if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '2' ORDER BY `ride_date` DESC ";
        } else if  ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '2' ORDER BY `ride_date` ASC ";
        } else if  ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '2' ORDER BY `total_fare` DESC ";
        } else if  ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '2' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '2'";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function sortUserCancelledRide($data, $conn, $id) {
		$row = array();
        if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '0' ORDER BY `ride_date` DESC ";
        } else if ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '0' ORDER BY `ride_date` ASC ";            
        } else if ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '0' ORDER BY `total_fare` DESC ";
        } else if ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '0' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`= '0'";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}


	function sortPendingRide($data, $conn) {
		$row = array();
        if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `status`= '1' ORDER BY `ride_date` DESC  ";
        } else if ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `status`= '1' ORDER BY `ride_date` ASC  ";
        } else if  ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `status`= '1' ORDER BY `total_fare` DESC ";
        } else if ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `status`= '1' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride`  WHERE `status`= '1' ";   
        }

        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function sortCompletedRide($data, $conn) {
		$row = array();
         if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '2' ORDER BY `ride_date` DESC ";
        } else if  ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '2' ORDER BY `ride_date` ASC ";
        } else if  ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '2' ORDER BY `total_fare` DESC ";
        } else if  ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '2' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '2'";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

	function sortCancelledRide($data, $conn) {
		$row = array();
         if ($data == 'descride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '0' ORDER BY `ride_date` DESC ";
        } else if ($data == 'ascride_date') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '0' ORDER BY `ride_date` ASC ";            
        } else if ($data == 'desctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '0' ORDER BY `total_fare` DESC ";
        } else if ($data == 'asctotal_fare') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '0' ORDER BY `total_fare` ASC ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `status`= '0'";
        }
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
	}

    function TotalUserexpenditure($conn,$id){
        $sql ="SELECT SUM(`total_fare`) FROM `tbl_ride` WHERE `customer_user_id` = '$id' ";
        $result= mysqli_query($conn,$sql);
        $row= mysqli_fetch_row($result);
        return $row;

    }
    
    function totalUserRides($conn,$id){
        $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id'";
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }

    function noUserPendingRides($conn,$id){
        $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' AND `status` = '1'";
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }

    function noUserCompletedRides($conn,$id){
        $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' AND `status` = '2'";
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }

    function noUserCancelledRides($conn,$id){
        $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' AND `status` = '0'";
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }
    function noUserLocations($conn,$id){
        $sql = "SELECT count( DISTINCT `dropup` ) FROM `tbl_ride` WHERE `customer_user_id` = '$id' AND `status` = '2' ";
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }


    function InvoicePrint($conn,$id){
        $row = array();
        $sql = "SELECT * FROM `tbl_ride` WHERE `ride_id` = '$id'";
       
        // return $sql;
        // exit();
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
      
    }

    function filterPendingRide($sdata, $conn)
    {
        $row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY)  and `status`='1' ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) and  `status`='1' ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' and  `status`='1' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' and  `status`='1' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' and `status`='1' ";
        } else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro'  and `status`='1' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE  `status`='1' ";
        }


        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
    }

    function filterUserCompletedRide($sdata, $conn, $id)
    {
        $row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY) and `customer_user_id` = '$id' and `status`='2' ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) and `customer_user_id` = '$id' and `status`='2' ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' and `customer_user_id` = '$id' and `status`='2' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' and `customer_user_id` = '$id' and `status`='2' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' and `customer_user_id` = '$id' and `status`='2' ";
        }else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro' and `customer_user_id` = '$id' and `status`='2' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`='2' ";
        }
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
    }
 
    function  filterUserCancelledRide($sdata, $conn, $id)
    {
        $row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY) and `customer_user_id` = '$id' and `status`='0' ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
			$sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) and `customer_user_id` = '$id' and `status`='0' ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' and `customer_user_id` = '$id' and `status`='0' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' and `customer_user_id` = '$id' and `status`='0' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' and `customer_user_id` = '$id' and `status`='0' ";
        } else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro' and `customer_user_id` = '$id' and `status`='0' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE `customer_user_id` = '$id' and `status`='0' ";
        }
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
    }

     function  filterCancelledRide($sdata, $conn)
    {
        $row = array();

        if ($sdata == 'week') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 7 DAY) and `status`='0' ORDER BY `ride_date`";
        } else if ($sdata == 'month') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `ride_date` > DATE_SUB(NOW(), INTERVAL 30 DAY) and `status`='0' ORDER BY `ride_date`";
        } else if ($sdata == 'cedSUV') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedSUV' and `status`='0' ";
        }else if ($sdata == 'cedMini') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMini' and `status`='0' ";
        }else if ($sdata == 'cedRoyal') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedRoyal' and `status`='0' ";
        } else if ($sdata == 'cedMicro') {
            $sql = "SELECT * FROM `tbl_ride` WHERE `cab` = 'cedMicro' and `status`='0' ";
        } else {
            $sql = "SELECT * FROM `tbl_ride` WHERE  and `status`='0' ";
        }
        $res = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_assoc($res)) {
            $row[] = $data;
        }
        return $row;
    }

    function deletePendingRide($loc,$conn){
     
        $sql = "DELETE FROM `tbl_ride` WHERE `ride_id`= '$loc' ";
      
        if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
        }
    }
}


?>