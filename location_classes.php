<?php
class location{
    public $id;
    public $name;
    public $distance;
    public $is_available;


    function fetchLocation($conn) 
    {
        $row = array();
        $sql = "SELECT `name`, `distance` FROM `tbl_location` WHERE is_available = '1' ";
        $res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
    }


    function allLocation($conn) 
    {
        $row = array();
        $sql = "SELECT * FROM `tbl_location` ";
        $res = mysqli_query($conn, $sql);
        while($data = mysqli_fetch_assoc($res))
        {
            $row[] = $data;
        }
        return $row;
    }

    function addLocation($loc,$dis,$conn){
        $sql = "SELECT * FROM tbl_location WHERE `name`='$loc' LIMIT 1";
        $this -> result = $conn->query($sql);

        if ($this-> result->num_rows > 0) {
    
            while($row = $this -> result->fetch_assoc()) {              
                if($row["name"]==$loc){
                    return "false";
                }
            }
        }
        
        $sql = 'INSERT INTO tbl_location(`name`,`distance`,`is_available`)VALUES("'.$loc.'","'.$dis.'","1")';
            if ($conn -> query($sql) === TRUE) {
                return "true";
            }

            else {
               echo "There is some error in entering ur location";
            }                
    }

    function deleteLocation($loc,$conn){
        // sql to delete a record
        $sql = "DELETE FROM `tbl_location` WHERE `id`= '$loc' ";
        // echo $sql;
        if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
        }
    }


    function editLocation($id , $conn){
        $data=array();
        $sql = "SELECT * from `tbl_location` WHERE  `id` = '$id' ";
        $this -> result = $conn -> query($sql);
        if($this -> result -> num_rows>0) {
            while($row = $this -> result-> fetch_assoc()) {
                $data[] = $row;
            }
        return $data;
        }
    }


    function updateLocation($id, $dist, $locname, $conn){
        $sql = "UPDATE `tbl_location` SET `distance` = '$dist' , `name` = '$locname' WHERE `id` = '$id' ";
        if (mysqli_query($conn, $sql)) {
            $msg = "Location is updated !";
        } else {
            $msg = "Update Failed !";
        }
        return $msg;
    }

    function totallocation($conn){
        $sql = 'SELECT * FROM `tbl_location` ';
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }

    function numAvailableLocation($conn){
        $sql = 'SELECT * FROM `tbl_location` WHERE  `is_available` ="1" ';
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }

    function notAvailableLocation($conn){
        $sql = 'SELECT * FROM `tbl_location` WHERE  `is_available` ="0" ';
        $this -> result = $conn -> query($sql); 
        $rowcount=mysqli_num_rows($this -> result);
        return $rowcount;   
    }

}
?>