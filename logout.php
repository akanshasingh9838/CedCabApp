<?php
    session_start();
    if(isset($_SESSION['userdata'])){
        //echo "WELCOME ".$_SESSION['userdata']['username'];
    }
    if(isset($_GET['id'])){
        //echo($_SESSION['userdata']['username']);   
        //echo($_GET['id']);
        session_destroy();
        unset($_SESSION['userdata']);
        header("location:login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Members</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div id="logout">
        <h2><?php echo "WELCOME ".$_SESSION['userdata']['username'] ?></h2><br><br>
        <a href="cabbook.php?id=logout">log out</a>
    </div>
</body>
</html>