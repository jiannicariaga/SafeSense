<?php
// Check if save button was clicked
if (isset($_POST['user-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Begin user session
    session_start();
    
    // Store global session veriables
    $id = $_SESSION['userID'];
    $username = $_SESSION['username'];
    // Store names passed via HTTP POST
    $newUsername = $_POST['new-username'];
    $password = $_POST['password'];
    
    // Check if any field is empty
    if (empty($newUsername) || empty($password)) {
        // Redirect to account settings page, retain new username
        header("Location: ../accountsettings.php?error=eu_emptyfields&newusername=".$newUsername);
        // Terminate script
        exit();
    }
    // Check if new username matches current username
    else if ($newUsername == $username) {
        // Redirect to account settings page
        header("Location: ../accountsettings.php?error=eu_sameusername");
        // Terminate script
        exit();
    }
    // Check if new username is invalid
    else if (!preg_match("/[a-zA-Z\d_-]{5,15}/", $newUsername)) {
        // Redirect to account settings page
        header("Location: ../accountsettings.php?error=eu_invalidnewusername");
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
            // Redirect to account settings page
            header("Location: ../accountsettings.php?error=eu_sqlerror");
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
                    // Redirect to account settings page, retain new username
                    header("Location: ../accountsettings.php?error=eu_invalidpassword&newusername=".$newUsername);
                    // Terminate script
                    exit();
                }
                // Update username
                else {
                    // Initialize query
                    $sql = "UPDATE users SET username=? WHERE userID=?";
                    // Initialize statement
                    $stmt = mysqli_stmt_init($conn);

                    // Check if prepared statement failed 
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        // Redirect to account settings page
                        header("Location: ../accountsettings.php?error=eu_sqlerror");
                        // Terminate script
                        exit();
                    } else {
                        // Bind new username and user ID to prepared statement
                        mysqli_stmt_bind_param($stmt, "si", $newUsername, $id);
                        // Execute prepared statement in database
                        mysqli_stmt_execute($stmt);

                        // Initialize query
                        $sql = "SELECT username FROM users WHERE userID=?";
                        // Initialize statement
                        $stmt = mysqli_stmt_init($conn);

                        // Check if prepared statement failed 
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            // Redirect to account settings page
                            header("Location: ../accountsettings.php?error=eu_sqlerror");
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
                                // Update global session variable passed from row
                                $_SESSION['username'] = $row['username'];
                            }
                        }
                    
                        // Redirect to account settings page
                        header("Location: ../accountsettings.php?editusername=success");
                        // Terminate script
                        exit();
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
    // Redirect to account settings page
    header("Location: ../accountsettings.php");
    // Terminate script
    exit();
}