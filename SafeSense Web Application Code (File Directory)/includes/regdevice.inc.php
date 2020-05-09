<?php
// Check if register device button was clicked
if (isset($_POST['reg-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Begin user session
    session_start();
    
    // Store global session variables
    $id = $_SESSION['userID'];
    // Store names passed via HTTP POST
    $authKey = $_POST['auth-key'];
    $password = $_POST['password'];
    
    // Check if any field is empty
    if (empty($authKey) || empty($password)) {
        // Redirect to register device page
        header("Location: ../registerdevice.php?error=rd_emptyfields");
        // Terminate script
        exit();
    }
    // Check if user is logged in
    else {
        // Initialize query
        $sql = "SELECT * FROM users WHERE userID=?";
        // Initialize statement
        $stmt = mysqli_stmt_init($conn);

        // Check if prepared statement failed 
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Redirect to register device page
            header("Location: ../registerdevice.php?error=rd_sqlerror");
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
                // Verify password and store result from row
                $passwordCheck = password_verify($password, $row['password']);

                // Check if password is invalid
                if ($passwordCheck == false) {
                    // Redirect to register device page
                    header("Location: ../registerdevice.php?error=rd_invalidpassword");
                    // Terminate script
                    exit();
                }
                // Check if device already exists in database
                else {
                    // Initialize query
                    $sql = "SELECT userID, authenticationKey FROM devices WHERE authenticationKey=?";
                    // Initialize statement
                    $stmt = mysqli_stmt_init($conn);

                    // Check if prepared statement failed 
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        // Redirect to sign up page
                        header("Location: ../signup.php?error=rd_sqlerror");
                        // Terminate script
                        exit();
                    } else {
                        // Bind authentication key to prepared statement
                        mysqli_stmt_bind_param($stmt, "s", $authKey);
                        // Execute prepared statement in database
                        mysqli_stmt_execute($stmt);
                        // Get and store result from database
                        $result = mysqli_stmt_get_result($stmt);

                        // Check if row exists
                        if ($row = mysqli_fetch_assoc($result)) {
                            // Check if device matches current device(s)
                            if ($id == $row['userID']) {
                                // Redirect to register device page
                                header("Location: ../registerdevice.php?error=rd_samedevice");
                                // Terminate script
                                exit();
                            }
                            // Check if device is already registered
                            else if ($row['userID'] !== null) {
                                // Redirect to register device page
                                header("Location: ../registerdevice.php?error=rd_devicenotfound");
                                // Terminate script
                                exit();
                            }
                            // Register device
                            else {
                                // Initialize query
                                $sql = "UPDATE devices SET userID=? WHERE authenticationKey=?";
                                // Initialize statement
                                $stmt = mysqli_stmt_init($conn);

                                // Check if prepared statement failed 
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    // Redirect to account settings page
                                    header("Location: ../accountsettings.php?error=rd_sqlerror");
                                    // Terminate script
                                    exit();
                                } else {
                                    // Bind user ID and authentication key to prepared statement
                                    mysqli_stmt_bind_param($stmt, "is", $id, $authKey);
                                    // Execute prepared statement in database
                                    mysqli_stmt_execute($stmt);
                                }
                                
                                // Redirect to register device page
                                header("Location: ../registerdevice.php?registerdevice=success");
                                // Terminate script
                                exit();
                            }
                        } else {
                            // Redirect to register device page
                            header("Location: ../registerdevice.php?error=rd_devicenotfound");
                            // Terminate script
                            exit();
                        }
                    }
                }
            } else {
                // Redirect to login page
                header("Location: ../index.php?error=unauthorized");
                // Terminate script
                exit();
            }
        }
    }
} else {
    // Redirect to register device page
    header("Location: ../registerdevice.php");
    // Terminate script
    exit();
}