<?php
    session_start();
    require '../ride.php';
    require '../config.php';
    require '../classes.php';
    require '../location_classes.php';

    $dbcon = new config();
    $ride = new ride();
    $user = new User();
    $location = new Location();
    $uid = $_SESSION['admindata']['admin_id'];
    // $id=$_SESSION['userdata']['user_id'];

    if ($_POST['action'] == 'approveRide') {
        $id = $_POST['id'];
        // echo $id;

        $msg = $ride->approveRide($id, $dbcon->conn);
        echo $msg;
    }

    if ($_POST['action'] == 'cancelRide') {
        $id = $_POST['id'];
        // echo $id;

        $msg = $ride->cancelRide($id, $dbcon->conn);
        echo $msg;
    }

    if ($_POST['action'] == 'deleteRide') {
        $id = $_POST['id'];
        // echo $id;

        $msg = $ride->deleteRide($id, $dbcon->conn);
        echo $msg;
    }

    if ($_POST['action'] == 'unblock') {
        $id = $_POST['id'];
        // echo $id;

        $msg = $user->unblockUser($id, $dbcon->conn);
        echo $msg;
    }

     if ($_POST['action'] == 'editlocation') {
        $id = $_POST['id'];
        // echo $id;
        $msg = $location-> editLocation($id, $dbcon->conn);
        echo  json_encode($msg);
    }

    
    if ($_POST['action'] == 'updatelocation') {
        $id = $_POST['id'];
        $dist = $_POST['dist'];
        $locname = $_POST['locname'];
        // echo $id;
        $msg = $location-> updateLocation($id, $dist, $locname, $dbcon->conn);
        echo  json_encode($msg);
    }

    if ($_POST['action'] == 'changepass') {
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        $msg = $user-> changePassword($oldpass,$newpass,$dbcon->conn,$uid);
        echo $msg;
    }

    if ($_POST['action'] == 'sorting') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortAllRide($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

    if ($_POST['action'] == 'filterAllRide') {
        $sdata = $_POST['sdata'];

        $filterAllRide = $ride->fetchFilterRide($sdata, $dbcon->conn);
        echo json_encode($filterAllRide);

    }


     if ($_POST['action'] == 'sortPendingRide') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortPendingRide($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

     if ($_POST['action'] == 'sortCompletedRide') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortCompletedRide($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

    if ($_POST['action'] == 'sortCancelledRide') {
        $sdata = $_POST['sdata'];
        $allRide = $ride->sortCancelledRide($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($allRide));
    }

    if ($_POST['action'] == 'filterPendingRide') {
        $sdata = $_POST['sdata'];

        $filterPendingRide = $ride->filterPendingRide($sdata, $dbcon->conn);
        echo json_encode($filterPendingRide);

    }

    if ($_POST['action'] == 'sortPendingUsersName') {
        $sdata = $_POST['sdata'];
        $alldata = $user->sortPendingUsersName($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($alldata));
    }

    if ($_POST['action'] == 'filterCancelledRide') {
        $sdata = $_POST['sdata'];

        $filterCancelledRide = $ride->filterCancelledRide($sdata, $dbcon->conn);
        echo json_encode($filterCancelledRide);

    }

    if ($_POST['action'] == 'sortApprovedUsersName') {
        $sdata = $_POST['sdata'];
        $alldata = $user->sortApprovedUsersName($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($alldata));
    }

    if ($_POST['action'] == 'sortAllUsersName') {
        $sdata = $_POST['sdata'];
        $alldata = $user->sortAllUsersName($sdata, $dbcon->conn);
        // print_r($allRide);
        print_r(json_encode($alldata));
    }


?>