



<?php  
//Connect to database
require'connectDB.php';


session_start();


if (isset($_SESSION['alert_message'])) {
    $alertMessage = $_SESSION['alert_message'];
    echo "<script>alert('$alertMessage');</script>";
    unset($_SESSION['alert_message']);
}

//Add user 
if (isset($_POST['Add'])) {
     
    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    $Gender = $_POST['gender'];
    $Password = $_POST['password'];

    $Pass = password_hash($Password, PASSWORD_BCRYPT);

    // echo "password: $Password";
    // echo "<script>alert('this is $Pass');</script>";

 
  
    //check if there any selected user
    $sql = "SELECT add_card FROM users WHERE id=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {

                if (!empty($Uname) && !empty($Number) && !empty($Email)) {
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=? AND id NOT like ?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "di", $Number, $user_id);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "SELECT device_dep FROM devices WHERE device_uid=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "s", $dev_uid);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                if ($row = mysqli_fetch_assoc($resultl)) {
                                    $dev_name = $row['device_dep'];
                                }
                                else{
                                    $dev_name = "All";
                                }
                            }

                            // updating admin table
                            // CREATE TABLE `admin` (
                            //     `id` int(11) NOT NULL,
                            //     `admin_name` varchar(30) NOT NULL,
                            //     `admin_email` varchar(80) NOT NULL,
                            //     `admin_pwd` longtext NOT NULL,
                            //     `user_type` varchar(30) 
                            //   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

                            $sql="INSERT INTO admin (admin_name, admin_email, admin_pwd,user_type) VALUES (?, ?, ?, 'user')";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_select_Fingerprint";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "sss", $Uname, $Email, $Pass);
                                mysqli_stmt_execute($result);
                            }
                                 
                                    //send mail to the user
                                    require 'PHPMailerAutoload.php';
                                    spl_autoload_register(function ($class) {
                                        include 'phpmailer/' . $class . '.php';
                                    });
                                    require 'credential.php';

                                    $mail = new PHPMailer;

                                    $mail->SMTPDebug = 0;                               // Enable verbose debug output

                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                    $mail->Username = EMAIL;                // SMTP username
                                    $mail->Password = PASS;                           // SMTP password
                                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                    $mail->Port = 587;                                    // TCP port to connect to

                                    $mail->setFrom(EMAIL, 'Student Transpotation Notification System');
                                    $mail->addAddress($Email);     // Add a recipient// Name is optional
                                    $mail->addReplyTo(EMAIL);
                                    // $mail->addCC('cc@example.com');
                                    // $mail->addBCC('bcc@example.com');

                                    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                                    $mail->isHTML(true);                                  // Set email format to HTML

                                    $mail->Subject = 'Registration Details of Student Transportation Notification System';
                                    $template = '
                                            Dear '.$Uname.',
                                            <p>We are pleased to inform you that your account with Student Transportation Notification System has been successfully created. Below are your login credentials:</p>
                                            <ul>
                                                <li><b>Serial Number:</b> ' . $Number . '</li>
                                                <li><b>Username:</b> ' . $Email . '</li>
                                                <li><b>Password:</b> ' . $Password . '</li>
                                            </ul>
                                            <p>If you encounter any issues during the login process or have any questions regarding your account, feel free to reach out to our support team at <a href="mailto:anandkrishna017@gmail.com" target="_blank">anandkrishna017@gmail.com</a> or 1234567890.</p>
                                            <p>Thank you for choosing Student Transportation Notification System. We appreciate your trust in our services.</p>
                                            <p>Best regards,<br>
                                            Anand Krishna K<br>
                                            School Administrator<br>
                                            GEC Thrissur<br>
                                            1234567890 </p>
                                        ';
                                    $mail->Body = $template;
                                    $mail->AltBody = 'Anand MCA';

                                    if(!$mail->send()) {
                                        // echo "<script>alert('not send Mailer Error: ' . $mail->ErrorInfo);</script>";
                                        // echo 'Message could not be sent.';
                                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    } else {
                                        // echo "<script>alert('Message has been sent');</script>";
                                        // echo 'Message has been sent';
                                    }
                            


                            $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, user_date=CURDATE(), device_uid=?, device_dep=?, add_card=1 WHERE id=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_select_Fingerprint";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "sdssssi", $Uname, $Number, $Gender, $Email, $dev_uid, $dev_name, $user_id );
                                mysqli_stmt_execute($result);

                                echo 1;
                                exit();
                            }
                        }
                        else {
                            echo "The serial number is already taken!";
                            exit();
                        }
                    }
                }
                else{
                    echo "Empty Fields";
                    exit();
                }
            }
            else{
                echo "This User is already exist";
                exit();
            }    
        }
        else {
            echo "There's no selected Card!";
            exit();
        }
    }


}
// Update an existance user 
if (isset($_POST['Update'])) {

    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    $Gender = $_POST['gender'];
    $Password = $_POST['password'];
    $Pass = password_hash($Password, PASSWORD_BCRYPT);
    // echo "<script>alert('this is uname $Uname');</script>";
    // echo "<script>alert('this is uname $Email');</script>";


    // echo "password: $Password";
    // echo "<script>alert('this is $Pass');</script>";

    //check if there any selected user
    $sql = "SELECT add_card FROM users WHERE id=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {
                echo "First, You need to add the User!";
                exit();
            }
            else{
                if (empty($Uname) && empty($Number) && empty($Email)) {
                    echo "Empty Fields";
                    exit();
                }
                else{
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=? AND id NOT like ?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "di", $Number, $user_id);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "SELECT device_dep FROM devices WHERE device_uid=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "s", $dev_uid);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                if ($row = mysqli_fetch_assoc($resultl)) {
                                    $dev_name = $row['device_dep'];
                                }
                                else{
                                    $dev_name = "All";
                                }
                            }
                                    
                            if (!empty($Uname) && !empty($Email)) {



                                $sql = "UPDATE admin SET admin_name = ?, admin_email = ?, admin_pwd = ? WHERE id=?";
                                $result = mysqli_stmt_init($conn);

                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_select_Fingerprint";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($result, "sssi", $Uname, $Email, $Pass,$user_id);
                                    mysqli_stmt_execute($result);
                                }
                                  


                                //send mail after updating the user
                                require 'PHPMailerAutoload.php';
                                spl_autoload_register(function ($class) {
                                    include 'phpmailer/' . $class . '.php';
                                });
                                require 'credential.php';

                                $mail = new PHPMailer;

                                $mail->SMTPDebug = 0;                               // Enable verbose debug output

                                $mail->isSMTP();                                      // Set mailer to use SMTP
                                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                $mail->Username = EMAIL;                // SMTP username
                                $mail->Password = PASS;                           // SMTP password
                                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 587;                                    // TCP port to connect to

                                $mail->setFrom(EMAIL, 'Student Transpotation Notification System');
                                $mail->addAddress($Email);     // Add a recipient// Name is optional
                                $mail->addReplyTo(EMAIL);
                                // $mail->addCC('cc@example.com');
                                // $mail->addBCC('bcc@example.com');

                                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                                $mail->isHTML(true);                                  // Set email format to HTML

                                $mail->Subject = 'Successful Update of Your Credentials';
                                $template = '
                                        Dear '.$Uname.',
                                        <p>I hope this email finds you well. We are writing to inform you that the credentials associated with Student Transportation Notification System have been successfully updated. Below are your login credentials:</p>
                                        <ul>
                                            <li><b>Serial Number:</b> ' . $Number . '</li>
                                            <li><b>Username:</b> ' . $Email . '</li>
                                            <li><b>Password:</b> ' . $Password . '</li>
                                        </ul>
                                        <p>If you encounter any issues during the login process or have any questions regarding your account, feel free to reach out to our support team at <a href="mailto:anandkrishna017@gmail.com" target="_blank">anandkrishna017@gmail.com</a> or 1234567890.</p>
                                        <p>Thank you for choosing Student Transportation Notification System. We appreciate your trust in our services.</p>
                                        <p>Best regards,<br>
                                        Anand Krishna K<br>
                                        School Administrator<br>
                                        GEC Thrissur<br>
                                        1234567890 </p>
                                    ';
                                $mail->Body = $template;
                                $mail->AltBody = 'Anand MCA';

                                if(!$mail->send()) {
                                    // echo "<script>alert('not send Mailer Error: ' . $mail->ErrorInfo);</script>";
                                    // echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                } else {
                                    // echo "<script>alert('Message has been sent');</script>";
                                    // echo 'Message has been sent';
                                }





                                $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, device_uid=?, device_dep=? WHERE id=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_select_Card";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "sdssssi", $Uname, $Number, $Gender, $Email, $dev_uid, $dev_name, $user_id );
                                    mysqli_stmt_execute($result);

                                    echo 1;
                                    exit();
                                }
                            }
                        }
                        else {
                            echo "The serial number is already taken!";
                            exit();
                        }
                    }
                }
            }    
        }
        else {
            echo "There's no selected User to be updated!";
            exit();
        }
    }
}
// select fingerprint 
if (isset($_GET['select'])) {

    $card_uid = $_GET['card_uid'];

    $sql = "SELECT * FROM users WHERE card_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $card_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        // echo "User Fingerprint selected";
        // exit();
        header('Content-Type: application/json');
        $data = array();
        if ($row = mysqli_fetch_assoc($resultl)) {
            foreach ($resultl as $row) {
                $data[] = $row;
            }
        }
        $resultl->close();
        $conn->close();
        print json_encode($data);
    } 
}
// delete user 
if (isset($_POST['delete'])) {

    $user_id = $_POST['user_id'];




    if (empty($user_id)) {
        echo "There no selected user to remove";
        exit();
    } else {

        $sql = "DELETE FROM admin WHERE id=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "SQL_Error_delete";
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "i", $user_id);
            mysqli_stmt_execute($result);
        }


        $sql = "DELETE FROM users WHERE id=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "SQL_Error_delete";
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "i", $user_id);
            mysqli_stmt_execute($result);
            echo 1;
            exit();
        }
    }
}
?>