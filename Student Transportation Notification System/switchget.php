<?php  
//Connect to database
require 'connectDB.php';
// date_default_timezone_set('Asia/Damascus');
date_default_timezone_set('Asia/Kolkata');
$d = date("Y-m-d");
$t = date("H:i:sa");
$button1State="None";
$button2State="None";
$ip="None";
$device_uid="f85b98c2a4a02a95";

if (isset($_GET['button1']) && isset($_GET['button2'])){

$button1State = $_GET['button1'];
echo "$button1State";
$button2State = $_GET['button2'];
echo "$button2State" ;
$ip = $_GET['ip'] ;

$sql = "SELECT * FROM devices WHERE device_uid=?";
$result = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($result, $sql)) {
    echo "SQL_Error_Select_device";
    exit();
}
else{
    mysqli_stmt_bind_param($result, "s", $device_uid);
    mysqli_stmt_execute($result);
    $resultl = mysqli_stmt_get_result($result);
    if ($row = mysqli_fetch_assoc($resultl)){
        $device_dep = $row['device_dep'];
        if($button1State == "Pressed"){

            $sql = "INSERT INTO switch (bus_name,date,time,status,location) VALUES (?, ?, ?, 'Bus is Started', ?)";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Bus_started";
                exit();
            }
            else{
                
                mysqli_stmt_bind_param($result, "ssss",$device_dep, $d,$t,$ip );
                mysqli_stmt_execute($result);
                echo "Bus is Started.";
                exit();
            }   
        }
        if($button2State == "Pressed"){

            $sql = "INSERT INTO switch (bus_name,date,time,status,location) VALUES (?, ?, ?, 'Bus has Problem', ?)";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Bus_Complaint";
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "ssss",$device_dep, $d,$t,$ip );
                mysqli_stmt_execute($result);
                echo "Bus problem";
                exit();
            }
            
        }

    }
}
}

?>