<?php
// Check if save button was clicked
if (isset($_POST['email-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Begin user session
    session_start();
    
    // Store global session variables
    $id = $_SESSION['userID'];
    $session_email = $_SESSION['email'];
    // Store names passed via HTTP POST
    $email = $_POST['email'];
    $newEmail = $_POST['new-email'];
    $password = $_POST['password'];
    
    // Check if any field is empty
    if (empty($email) || empty($newEmail) || empty($password)) {
        // Redirect to account settings page, retain username
        header("Location: ../accountsettings.php?error=ee_emptyfields&email=".$email."&newemail=".$newEmail);
        // Terminate script
        exit();
    }
    // Check if current email is invalid
    else if ($email !== $session_email) {
        // Redirect to account settings page
        header("Location: ../accountsettings.php?error=ee_invalidemail");
        // Terminate script
        exit();
    }
    // Check if new email matches current email
    else if ($newEmail == $session_email) {
        // Redirect to account settings page, retain email
        header("Location: ../accountsettings.php?error=ee_sameemail&email=".$email);
        // Terminate script
        exit();
    }
    // Check if new email is invalid
    else if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        // Redirect to account settings page, retain email
        header("Location: ../accountsettings.php?error=ee_invalidnewemail&email=".$email);
        // Terminate script
        exit();
    }
    // Check if new email already exists in database
    else {
        // Initialize query
        $sql = "SELECT email FROM users WHERE email=?";
        // Initialize statement
        $stmt = mysqli_stmt_init($conn);

        // Check if prepared statement failed 
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Redirect to sign up page
            header("Location: ../signup.php?error=sqlerror");
            // Terminate script
            exit();
        } else {
            // Bind new email to prepared statement
            mysqli_stmt_bind_param($stmt, "s", $newEmail);
            // Execute prepared statement in database
            mysqli_stmt_execute($stmt);
            // Store result from database
            mysqli_stmt_store_result($stmt);
            // Return number of rows and store from result
            $rows = mysqli_stmt_num_rows($stmt);

            // Check if rows exist
            if ($rows > 0) {
                // Redirect to account settings page, retain email
                header("Location: ../accountsettings.php?error=ee_newemailused&email=".$email);
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
                    header("Location: ../accountsettings.php?error=ee_sqlerror");
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
                            // Redirect to account settings page, retain current email and new email
                            header("Location: ../accountsettings.php?error=ee_invalidpassword&email=".$email."&newemail=".$newEmail);
                            // Terminate script
                            exit();
                        }
                        // Update email
                        else {
                            // Initialize query
                            $sql = "UPDATE users SET email=? WHERE userID=?";
                            // Initialize statement
                            $stmt = mysqli_stmt_init($conn);

                            // Check if prepared statement failed 
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                // Redirect to account settings page
                                header("Location: ../accountsettings.php?error=ee_sqlerror");
                                // Terminate script
                                exit();
                            } else {
                                // Bind new email and user ID to prepared statement
                                mysqli_stmt_bind_param($stmt, "si", $newEmail, $id);
                                // Execute prepared statement in database
                                mysqli_stmt_execute($stmt);

                                // Initialize query
                                $sql = "SELECT email FROM users WHERE userID=?";
                                // Initialize statement
                                $stmt = mysqli_stmt_init($conn);

                                // Check if prepared statement failed 
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    // Redirect to account settings page
                                    header("Location: ../accountsettings.php?error=ee_sqlerror");
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
                                        $_SESSION['email'] = $row['email'];
                                    }
                                }

                                // Redirect to account settings page
                                header("Location: ../accountsettings.php?editemail=success");
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
        }
    }
} else {
    // Redirect to account settings page
    header("Location: ../accountsettings.php");
    // Terminate script
    exit();
}