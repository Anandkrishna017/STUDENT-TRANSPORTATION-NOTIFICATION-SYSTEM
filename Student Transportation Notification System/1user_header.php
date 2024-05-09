<?php
if (!isset($_SESSION['user-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users_window</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon.png">

    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="css/Users.css">
    <script>
      $(window).on("load resize ", function() {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css({'padding-right':scrollWidth});
    }).resize();
    </script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel='stylesheet' type='text/css' href="css/bootstrap.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/header.css"/>

</head>

<!-- Header.php -->

<header>
<div class="header">
	<div class="logo">
		<a href="index.php">STUDENT TRANSPORTATION NOTIFICATION SYSTEM</a>
	</div>
</div>
<div class="topnav" id="myTopnav">
	<!-- <a href="index.php">Users</a> -->
    <!-- <a href="ManageUsers.php">Manage Users</a> -->
    <a href="1userLog_window.php">Users Log</a>
	<a href="1switch.php">Bus Status</a>
    <!-- <a href="devices.php">Devices</a> -->
    <?php  
    	if (isset($_SESSION['user-name'])) {
    		// echo '<a href="#" data-toggle="modal" data-target="#admin-account">'.$_SESSION['user-name'].'</a>';
    		echo '<a href="logout.php">Log Out</a>';
    	}
    	else{
    		echo '<a href="login.php">Log In</a>';
    	}
    ?>
    <a href="javascript:void(0);" class="icon" onclick="navFunction()">
	  <i class="fa fa-bars"></i></a>
</div>
<div class="up_info1 alert-danger"></div>
<div class="up_info2 alert-success"></div>
</header>
<script>
	function navFunction() {
	  var x = document.getElementById("myTopnav");
	  if (x.className === "topnav") {
	    x.className += " responsive";
	  } else {
	    x.className = "topnav";
	  }
	}
</script>


















<!-- end of hearder.php -->
<body>
<main>

<!-- <h1>This is user<h1> -->
</main>
</body>
</html>