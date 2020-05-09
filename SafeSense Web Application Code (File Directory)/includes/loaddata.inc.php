<?php
// Include databse handler
require "dbh.inc.php";

// Begin user session
session_start();

// Store global session variables
$id = $_SESSION['userID'];

// Initialize query 
$sql = "SELECT devices.deviceName, devices.deviceLocation, activity_log.data, activity_log.readTime FROM devices INNER JOIN activity_log ON devices.deviceID = activity_log.deviceID WHERE devices.userID=?";
// Initialize statement
$stmt = mysqli_stmt_init($conn);

// Check if prepared statement failed 
if (!mysqli_stmt_prepare($stmt, $sql)) {
    // Redirect to login page
    header("Location: index.php?error=sqlerror");
    // Terminate script
    exit();
} else {
    // Bind user ID to prepared statement
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Execute prepared statement in database
    mysqli_stmt_execute($stmt);
    // Get and store result from database
    $result = mysqli_stmt_get_result($stmt);

    // Check if rows exist
    if (mysqli_num_rows($result) > 0) {
        // Execute while rows are fetched
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <!-- Feedback -->
            <div class="data">
                <p>
                    <strong class="name-location">[<?php echo $row["deviceName"] ?>] [<?php echo $row["deviceLocation"] ?>]</strong><br>
                    <?php echo $row["readTime"] ?> (UTC)<br><?php echo $row["data"] ?>m
                </p>
            </div>
<?php 
        }
        
        // Terminate script
        exit();
    } else { 
?>
        <!-- Message -->
        <div class="no-devices">
            <p>No device connected.</p>
            <p>Add a new SafeSense device <a href="registerdevice.php" class="redirect">here</a>.</p>
        </div>
<?php
        // Terminate script
        exit();
    }
}