<div class="table-responsive" style="max-height: 500px;"> 
    <table class="table">
      <thead class="table-primary">
        <tr>
          <!-- <th>ID | Name</th> -->
          <th>SchoolBus Name</th>
          <th>Date</th>
          <th>Time</th>
          <th>Current Status</th>
          <th>Location</th>
          
        </tr>
      </thead>
      <tbody class="table-secondary">
        <?php
          //Connect to database
          require'connectDB.php';

            $sql = "SELECT * FROM switch";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo '<p class="error">SQL Error</p>';
            }
            else{
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
              if (mysqli_num_rows($resultl) > 0){
                  while ($row = mysqli_fetch_assoc($resultl)){
          ?>
                      <TD><?php echo $row['bus_name'];?></TD>
                      <TD><?php echo $row['date'];?></TD>
                      <TD><?php echo $row['time'];?></TD>
                      <TD><?php echo $row['status'];?></TD>
                      <TD><?php $ipAddress = $row["location"]; ?><a href="http://<?php echo $ipAddress; ?>" target="_blank"><font color="yellow">click here</font></a></TD>
                      
                      </TR>
        <?php
                }   
            }
          }
        ?>
      </tbody>
    </table>
  </div>