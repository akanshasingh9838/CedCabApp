<?php
	session_start();
	require 'location_classes.php';
	require 'config.php';
	$dbcon = new config();

	$fare=0;
	$pickup=$_POST['pickup'];
	$drop=$_POST['drop'];
	$cabtype=$_POST['cabtype'];
	$luggage=$_POST['luggage'];
	$_SESSION['ride']=array('pickup'=>$pickup,'drop'=>$drop,'cabtype'=>$cabtype,'luggage'=> $luggage);	
 	$loc = new location();
 	$all_loc = $loc-> fetchLocation($dbcon -> conn);
 	// print_r($all_loc);
 	foreach ($all_loc as $key => $value) {
 		$distance[$value['name']] = $value['distance'];
 	}	
	$TotalDistance= abs($distance[$drop] - $distance[$pickup]);
	$_SESSION['ride']=array('pickup'=>$pickup,'dropup'=>$drop,'cabtype'=>$cabtype,'luggage'=> $luggage,'distance'=>$TotalDistance);
	// if (isset($_SESSION['ride']) && (time() - $_SESSION['ride'] > 10)) {
	//     session_unset();     
	//     session_destroy();  
	// }
	// $_SESSION['ride'] = time();
	
	if($cabtype=="CedMicro"){
		$fare+=50;
		if($TotalDistance<=10){
			$fare+=$TotalDistance*13.50;
		}
		else if($TotalDistance>10 && $TotalDistance<=60){
			$fare+=10*13.5;
			$fare+=($TotalDistance-10)*12.0;
		}
		else if($TotalDistance>60 && $TotalDistance<=160){
			$fare+=(10*13.5)+(50*12.0);
			$fare+=($TotalDistance-60)*12.0;
		}
		else{
			$fare+=(10*13.5)+(50*12.0)+(100*10.20);
			$fare+=($TotalDistance-160)*8.50;
		}
		// echo $fare;
	}

	elseif($cabtype=="CedMini"){
		$fare+=150;
		if($TotalDistance<=10){
			$fare+=$TotalDistance*14.50;
		}
		else if($TotalDistance>10 && $TotalDistance<=60){
			$fare+=10*14.50;
			$fare+=($TotalDistance-10)*13.0;
		}
		else if($TotalDistance>60 && $TotalDistance<=160){
			$fare+=(10*14.50)+(50*13.0);
			$fare+=($TotalDistance-60)*11.20;
		}
		else{
			$fare+=(10*14.50)+(50*13.0)+(100*11.20);
			$fare+=($TotalDistance-160)*9.50;
		}
	}

	elseif($cabtype=="CedRoyal"){
		$fare+=200;
		if($TotalDistance<=10){
			$fare+=$TotalDistance*15.50;
		}
		else if($TotalDistance>10 && $TotalDistance<=60){
			$fare+=10*15.50;
			$fare+=($TotalDistance-10)*14.0;
		}
		else if($TotalDistance>60 && $TotalDistance<=160){
			$fare+=(10*15.50)+(50*14.0);
			$fare+=($TotalDistance-60)*12.20;
		}
		else{
			$fare+=(10*15.50)+(50*14.0)+(100*12.20);
			$fare+=($TotalDistance-160)*10.50;
		}
		// echo $fare;
	}

	else{
		$fare+=250;
		if($TotalDistance<=10){
			$fare+=$TotalDistance*16.50;
		}
		else if($TotalDistance>10 && $TotalDistance<=60){
			$fare+=10*16.50;
			$fare+=($TotalDistance-10)*15.0;
		}
		else if($TotalDistance>60 && $TotalDistance<=160){
			$fare+=(10*16.50)+(50*15.0);
			$fare+=($TotalDistance-60)*13.20;
		}
		else{
			$fare+=(10*16.50)+(50*15.0)+(100*13.20);
			$fare+=($TotalDistance-160)*11.50;
		}
		 
	}
	// echo $fare;
if($cabtype != "CedSUV")
{
	if($luggage != ""){
	if($luggage ==0){
		$fare+=0;
	}
	else if($luggage >0 && $luggage <=10 ){
		$fare+=50;
	}
	else if ($luggage >10 && $luggage <=20) {
		$fare+=100;
	}
	else{
		$fare+=200;
	}

	echo $fare;
	$_SESSION['ride']['fare'] = $fare;
	}
	else{
	echo $fare;
	$_SESSION['ride']['fare'] = $fare;
	}
}
else{
	if($luggage != ""){
	if($luggage ==0){
		$fare+=0;
	}
	else if($luggage >0 && $luggage <=10 ){
		$fare+=100;
	}
	else if ($luggage >10 && $luggage <=20) {
		$fare+=200;
	}
	else{
		$fare+=400;
	}

	echo $fare;
	$_SESSION['ride']['fare'] = $fare;
	}
	else{
	echo $fare;
	$_SESSION['ride']['fare'] = $fare;
	}
}

?>





 