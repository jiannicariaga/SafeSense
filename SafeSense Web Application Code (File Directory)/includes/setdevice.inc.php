<?php
// Check if save button was clicked
if (isset($_POST['set-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Begin user session
    session_start();
    
    // Store global session variables
    $id = $_SESSION['userID'];
    // Store names passed via HTTP POST
    $maxRange = $_POST['max-range'];
    $sensitivity = $_POST['sensitivity'];
    $showActivity = $_POST['show-activity'];
    
    // Initialize query
    $sql = "SELECT * FROM devices WHERE userID=?";
    // Initialize statement
    $stmt = mysqli_stmt_init($conn);

    // Check if prepared statement failed 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Redirect to device settings page
        header("Location: ../devicesettings.php?error=sd_sqlerror");
        // Terminate script
        exit();
    }
    // Check if user is logged in
    else {
        // Bind user ID to prepared statement as String
        mysqli_stmt_bind_param($stmt, "i", $id);
        // Execute prepared statement in database
        mysqli_stmt_execute($stmt);
        // Get and store result from database
        $result = mysqli_stmt_get_result($stmt);

        // Check if row exists
        if ($row = mysqli_fetch_assoc($result)) {
            // Check if new settings matches current settings
            if ($maxRange == $row['maxRange'] && $sensitivity == $row['sensitivity'] && $showActivity == $row['showActivity']) {
                // Redirect to device settings page
                header("Location: ../devicesettings.php?error=sd_samesettings");
                // Terminate script
                exit();
            } 
            // Update device settings
            else {
                // Initialize query
                $sql = "UPDATE devices SET maxRange=?, sensitivity=?, showActivity=? WHERE userID=?";
                // Initialize statement
                $stmt = mysqli_stmt_init($conn);

                // Check if prepared statement failed 
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    // Redirect to account settings page
                    header("Location: ../accountsettings.php?error=sd_sqlerror");
                    // Terminate script
                    exit();
                } else {
                    // Bind max range, sensitivity, show activity, and user ID to prepared statement
                    mysqli_stmt_bind_param($stmt, "sssi", $maxRange, $sensitivity, $showActivity, $id);
                    // Execute prepared statement in database
                    mysqli_stmt_execute($stmt);
                }
                
                // Redirect to device settings page
                header("Location: ../devicesettings.php?editsettings=success");
                // Terminate script
                exit();
            }
        } else {
            // Redirect to login page
            header("Location: ../index.php?error=unauthorized");
            // Terminate script
            exit();
        }
    }
} else {
    // Redirect to device settings page
    header("Location: ../devicesettings.php");
    // Terminate script
    exit();
}