<?php
// Check if save button was clicked
if (isset($_POST['pass-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Begin user session
    session_start();
    
    // Store global session variables
    $id = $_SESSION['userID'];
    // Store names passed via HTTP POST
    $password = $_POST['password'];
    $newPassword = $_POST['new-password'];
    $newPasswordConfirm = $_POST['new-password-confirm'];
    
    // Check if any field is empty
    if (empty($password) || empty($newPassword) || empty($newPasswordConfirm)) {
        // Redirect to account settings page
        header("Location: ../accountsettings.php?error=ep_emptyfields");
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
            header("Location: ../accountsettings.php?error=ep_sqlerror");
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
                
                // Check if current password is invalid
                if ($passwordCheck == false) {
                    // Redirect to account settings page
                    header("Location: ../accountsettings.php?error=ep_invalidpassword");
                    // Terminate script
                    exit();
                }
                // Check if new password matches current password
                else if ($newPassword == $password) {
                    // Redirect to account settings page
                    header("Location: ../accountsettings.php?error=ep_samepassword");
                    // Terminate script
                    exit();
                }
                // Check if new password is invalid
                else if (!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/", $newPassword)) {
                    // Redirect to account settings page
                    header("Location: ../accountsettings.php?error=ep_invalidnewpassword");
                    // Terminate script
                    exit();
                }
                // Check if new passwords do not match
                else if ($newPassword !== $newPasswordConfirm) {
                    // Redirect to account settings page
                    header("Location: ../accountsettings.php?error=ep_passwordsdonotmatch");
                    // Terminate script
                    exit();
                }
                // Update password
                else {
                    // Initialize query
                    $sql = "UPDATE users SET password=? WHERE userID=?";
                    // Initialize statement
                    $stmt = mysqli_stmt_init($conn);

                    // Check if prepared statement failed 
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        // Redirect to account settings page
                        header("Location: ../accountsettings.php?error=ep_sqlerror");
                        // Terminate script
                        exit();
                    } else {
                        // Hash new password
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        // Bind hashed new password and user ID to prepared statement
                        mysqli_stmt_bind_param($stmt, "si", $hashedNewPassword, $id);
                        // Execute prepared statement in database
                        mysqli_stmt_execute($stmt);

                        // Redirect to account settings page
                        header("Location: ../accountsettings.php?editpassword=success");
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