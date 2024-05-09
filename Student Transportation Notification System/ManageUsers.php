
<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Users</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/manageusers.css">

    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
	
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

	</script>
    <script type="text/javascript" src="js/bootbox.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="js/manage_users.js"></script>
	<script>
	  	$(window).on("load resize ", function() {
		    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
		    $('.tbl-header').css({'padding-right':scrollWidth});
		}).resize();
	</script>
	<script>
	  $(document).ready(function(){
	  	  $.ajax({
	        url: "manage_users_up.php"
	        }).done(function(data) {
	        $('#manage_users').html(data);
	      });
	    setInterval(function(){
	      $.ajax({
	        url: "manage_users_up.php"
	        }).done(function(data) {
	        $('#manage_users').html(data);
	      });
	    },5000);
	  });





   



	</script>


</head>
<body>
<?php include'header.php';?>

<main>
	<h1 class="slideInDown animated" style="color:white;">Add a new User or update his information <br> or remove him</h1>
	<div class="form-style-5 slideInDown animated">
		<form enctype="multipart/form-data">
			<div class="alert_user"></div>
			<fieldset>
				<legend><span class="number">1</span> User Info</legend>
				<input type="text" name="user_id" id="user_id" placeholder="User Id...">
				<input type="text" name="name" id="name" placeholder="User Name...">
				<input type="text" name="number" id="number" placeholder="Serial Number...">
				<input type="email" name="email" id="email" placeholder="User Email...">
                <input type="password" name="password" id="password" placeholder="Password...">

		



			</fieldset>
















			<!-- changed code anand -->

            <!-- <fieldset> -->
				<style>
					.form-style-5 input[type="password"] {
								font-family: Georgia, "Times New Roman", Times, serif;
								background: rgba(255, 255, 255, 0.1);
								border: none;
								border-radius: 4px;
								font-size: 14px;
								margin: 0;
								outline: 0;
								padding: 10px;
								width: 100%;
								box-sizing: border-box;
								-webkit-box-sizing: border-box;
								-moz-box-sizing: border-box;
								background-color: #e8eeef;
								color: #8a97a0;
								-webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
								box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
								margin-bottom: 30px;
								border: 1px solid #e8eeef;
								}

								.form-style-5 input[type="password"]:focus {
								background: #d2d9dd;
								color: #000;
								}

								.form-style-5 input[type="password"]:hover {
								border: 1px solid #388994;
								}


								.form-style-5{
									height: 750px;
								}


													</style>
									<!-- <legend><span class="number">2</span> Set Password</legend> -->
									<!-- <input type="password" name="password" id="password" placeholder="User Password..."> -->
								<!-- </fieldset> -->

<!-- changed code by anand -->


			<fieldset>
			<legend><span class="number">3</span> Additional Info</legend>
			<label>
				<label for="Device"><b>School Bus Name:</b></label>
                    <select class="dev_sel" name="dev_sel" id="dev_sel" style="color: #000;">
                      <option value="0">All SchoolBus</option>
                      <?php
                        require'connectDB.php';
                        $sql = "SELECT * FROM devices ORDER BY device_name ASC";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo '<p class="error">SQL Error</p>';
                        } 
                        else{
                            mysqli_stmt_execute($result);
                            $resultl = mysqli_stmt_get_result($result);
                            while ($row = mysqli_fetch_assoc($resultl)){
                      ?>
                              <option value="<?php echo $row['device_uid'];?>"><?php echo $row['device_dep']; ?></option>
                      <?php
                            }
                        }
                      ?>
                    </select>
				<input type="radio" name="gender" class="gender" value="Female">Female
	          	<input type="radio" name="gender" class="gender" value="Male" checked="checked">Male
	      	</label >
			</fieldset>
			<button type="button"  name="user_add" class="user_add" id="user_add">Add User</button>
			<button type="button" name="user_upd" class="user_upd" id="user_upd">Update User</button>
			<button type="button" name="user_rmo" class="user_rmo" id="user_rmo">Remove User</button>
		</form>
	</div>
	<!--User table-->
	<div class="section">
		
		<div class="slideInRight animated">
			<div id="manage_users"></div>
		</div>
	</div>
</main>
</body>
</html>