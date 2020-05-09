<?php
// Check if save button was clicked
if (isset($_POST['edit-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Begin user session
    session_start();
    
    // Store global session variables
    $id = $_SESSION['userID'];
    // Store names passed via HTTP POST
    $newName = $_POST['new-name'];
    $newLocation = $_POST['new-location'];
    
    // Check if both fields are empty
    if (empty($newName) && empty($newLocation)) {
        // Redirect to device settings page
        header("Location: ../devicesettings.php?error=ed_emptyfields");
        // Terminate script
        exit();
    }
    // Check if new location field is empty
    else if (empty($newLocation)) {
        // Check if new name is invalid
        if (!preg_match("/[a-zA-Z\d\s'_-]{1,10}/", $newName)) {
            // Redirect to device settings page
            header("Location: ../devicesettings.php?error=ed_invalidnewname");
            // Terminate script
            exit();
        }
        // Check if user is logged in
        else {
            // Initialize query
            $sql = "SELECT * FROM devices WHERE userID=?";
            // Initialize statement
            $stmt = mysqli_stmt_init($conn);

            // Check if prepared statement failed 
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // Redirect to device settings page
                header("Location: ../devicesettings.php?error=ed_sqlerror");
                // Terminate script
                exit();
            } else {
                // Bind user ID to prepared statement
                mysqli_stmt_bind_param($stmt, "i", $id);
                // Execute prepared statement in database
                mysqli_stmt_execute($stmt);
                // Get and store result from database
                $result = mysqli_stmt_get_result($stmt);

                // Check if row exists
                if ($row = mysqli_fetch_assoc($result)) {
                    // Check if new name matches current name
                    if ($newName == $row['deviceName']) {
                        // Redirect to device settings page
                        header("Location: ../devicesettings.php?error=ed_samename");
                        // Terminate script
                        exit();
                    }
                    // Update location
                    else {
                        // Initialize query
                        $sql = "UPDATE devices SET deviceName=? WHERE userID=?";
                        // Initialize statement
                        $stmt = mysqli_stmt_init($conn);

                        // Check if prepared statement failed 
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            // Redirect to account settings page
                            header("Location: ../devicesettings.php?error=ed_sqlerror");
                            // Terminate script
                            exit();
                        } else {
                            // Bind max range, sensitivity, show activity, and user ID to prepared statement
                            mysqli_stmt_bind_param($stmt, "si", $newName, $id);
                            // Execute prepared statement in database
                            mysqli_stmt_execute($stmt);
                        }

                        // Redirect to device settings page
                        header("Location: ../devicesettings.php?editdevice=success");
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
        }
    }
    // Check if new name field is empty
    else if (empty($newName)) {
        // Check if new location is invalid
        if (!preg_match("/[a-zA-Z\d\s'_-]{1,10}/", $newLocation)) {
            // Redirect to device settings page
            header("Location: ../devicesettings.php?error=ed_invalidnewlocation");
            // Terminate script
            exit();
        }
        // Check if user is logged in
        else {
            // Initialize query
            $sql = "SELECT * FROM devices WHERE userID=?";
            // Initialize statement
            $stmt = mysqli_stmt_init($conn);

            // Check if prepared statement failed 
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // Redirect to device settings page
                header("Location: ../devicesettings.php?error=ed_sqlerror");
                // Terminate script
                exit();
            } else {
                // Bind user ID to prepared statement
                mysqli_stmt_bind_param($stmt, "i", $id);
                // Execute prepared statement in database
                mysqli_stmt_execute($stmt);
                // Get and store result from database
                $result = mysqli_stmt_get_result($stmt);

                // Check if row exists
                if ($row = mysqli_fetch_assoc($result)) {
                    // Check if new location matches current location
                    if ($newLocation == $row['deviceLocation']) {
                        // Redirect to device settings page
                        header("Location: ../devicesettings.php?error=ed_samelocation");
                        // Terminate script
                        exit();
                    }
                    // Update location
                    else {
                        // Initialize query
                        $sql = "UPDATE devices SET deviceLocation=? WHERE userID=?";
                        // Initialize statement
                        $stmt = mysqli_stmt_init($conn);

                        // Check if prepared statement failed 
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            // Redirect to account settings page
                            header("Location: ../devicesettings.php?error=ed_sqlerror");
                            // Terminate script
                            exit();
                        } else {
                            // Bind max range, sensitivity, show activity, and user ID to prepared statement
                            mysqli_stmt_bind_param($stmt, "si", $newLocation, $id);
                            // Execute prepared statement in database
                            mysqli_stmt_execute($stmt);
                        }

                        // Redirect to device settings page
                        header("Location: ../devicesettings.php?editdevice=success");
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
        }
    }
    //
    else {
        // Check if new name and location are invalid
        if (!preg_match("/[a-zA-Z\d\s'_-]{1,10}/", $newName) && !preg_match("/[a-zA-Z\d\s'_-]{1,10}/", $newLocation)) {
            // Redirect to device settings page, retain new location
            header("Location: ../devicesettings.php?error=ed_invalidnewnameandlocation");
            // Terminate script
            exit();
        }
        // Check if new name is invalid
        else if (!preg_match("/[a-zA-Z\d\s'_-]{1,10}/", $newName)) {
            // Redirect to device settings page, retain new location
            header("Location: ../devicesettings.php?error=ed_invalidnewname&newlocation=".$newLocation);
            // Terminate script
            exit();
        }
        // Check if new location is invalid
        else if (!preg_match("/[a-zA-Z\d\s'_-]{1,10}/", $newLocation)) {
            // Redirect to device settings page, retain new name
            header("Location: ../devicesettings.php?error=ed_invalidnewlocation&newname=".$newName);
            // Terminate script
            exit();
        }
        // Check if user is logged in
        else {
            // Initialize query
            $sql = "SELECT * FROM devices WHERE userID=?";
            // Initialize statement
            $stmt = mysqli_stmt_init($conn);

            // Check if prepared statement failed 
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // Redirect to device settings page
                header("Location: ../devicesettings.php?error=ed_sqlerror");
                // Terminate script
                exit();
            } else {
                // Bind user ID to prepared statement
                mysqli_stmt_bind_param($stmt, "i", $id);
                // Execute prepared statement in database
                mysqli_stmt_execute($stmt);
                // Get and store result from database
                $result = mysqli_stmt_get_result($stmt);

                // Check if row exists
                if ($row = mysqli_fetch_assoc($result)) {
                    // Check if new name and location matches current name and location
                    if ($newName == $row['deviceName'] && $newLocation == $row['deviceLocation']) {
                        // Redirect to device settings page
                        header("Location: ../devicesettings.php?error=ed_samenameandlocation");
                        // Terminate script
                        exit();
                    }
                    // Update name and location
                    else {
                        // Initialize query
                        $sql = "UPDATE devices SET deviceName=?, deviceLocation=? WHERE userID=?";
                        // Initialize statement
                        $stmt = mysqli_stmt_init($conn);

                        // Check if prepared statement failed 
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            // Redirect to account settings page
                            header("Location: ../devicesettings.php?error=ed_sqlerror");
                            // Terminate script
                            exit();
                        } else {
                            // Bind max range, sensitivity, show activity, and user ID to prepared statement
                            mysqli_stmt_bind_param($stmt, "ssi", $newName, $newLocation, $id);
                            // Execute prepared statement in database
                            mysqli_stmt_execute($stmt);
                        }

                        // Redirect to device settings page
                        header("Location: ../devicesettings.php?editdevice=success");
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
        }
    }
} else {
    // Redirect to device settings page
    header("Location: ../devicesettings.php");
    // Terminate script
    exit();
}                       