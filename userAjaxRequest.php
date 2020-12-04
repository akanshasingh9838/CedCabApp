<?php
    session_start();
    require 'ride.php';
    require 'config.php';
    require 'classes.php';
    require 'location_classes.php';

    $dbcon = new config();
    $ride = new ride();
    $user = new User();
    $location = new Location();
    $uid = $_SESSION['userdata']['user_id'];

    if ($_POST['action'] == 'changeinfo') {
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $msg = $user->changeInfo($name,$mobile, $uid, $dbcon->conn);
        echo $msg;
    }

    if ($_POST['action'] == 'changepass') {
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        if($oldpass == $newpass){
            $msg = false;
            echo $msg;
        }
        else{
            $msg = $user->changeUserPassword($oldpass, $newpass , $uid, $dbcon->conn);
            // session_destroy();
            echo $msg;
        }
    }


    if ($_POST['action'] == 'sorting') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortUserAllRide($sdata, $dbcon->conn, $uid);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

    if ($_POST['action'] == 'filterAllRide') {
        $sdata = $_POST['sdata'];

        $filterAllRide = $ride->fetchUserFilterRide($sdata, $dbcon->conn,$uid);
        echo json_encode($filterAllRide);

    }

     if ($_POST['action'] == 'UserPendingsorting') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortUserPendingRide($sdata, $dbcon->conn, $uid);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

    if ($_POST['action'] == 'filterUserPendingRide') {
        $sdata = $_POST['sdata'];

        $filterAllRide = $ride->filterUserPendingRide($sdata, $dbcon->conn,$uid);
        echo json_encode($filterAllRide);

    }

    if ($_POST['action'] == 'sortUserCompletedRide') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortUserCompletedRide($sdata, $dbcon->conn, $uid);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

    if ($_POST['action'] == 'sortUserCancelledRide') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortUserCancelledRide($sdata, $dbcon->conn, $uid);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

     if ($_POST['action'] == 'filterUserCompletedRide') {
        $sdata = $_POST['sdata'];

        $filterAllRide = $ride->filterUserCompletedRide($sdata, $dbcon->conn,$uid);
        echo json_encode($filterAllRide);

    } 
      if ($_POST['action'] == 'filterUserCancelledRide') {
        $sdata = $_POST['sdata'];

        $filterAllRide = $ride-> filterUserCancelledRide($sdata, $dbcon->conn,$uid);
        echo json_encode($filterAllRide);

    }
?>