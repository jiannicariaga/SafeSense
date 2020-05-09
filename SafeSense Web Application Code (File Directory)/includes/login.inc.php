<?php
// Check if login button was clicked
if (isset($_POST['login-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Store names passed via HTTP POST
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Check if any field is empty
    if (empty($email) || empty($password)) {
        // Redirect to login page, reetain email
        header("Location: ../index.php?error=emptyfields&email=".$email);
        // Terminate script
        exit();
    }
    // Check if email already exists in database
    else {
        // Initialize query
        $sql = "SELECT * FROM users WHERE email=?";
        // Initialize statement
        $stmt = mysqli_stmt_init($conn);
        
        // Check if prepared statement failed 
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Redirect to login page
            header("Location: ../index.php?error=sqlerror");
            // Terminate script
            exit();
        } else {
            // Bind email to prepared statement
            mysqli_stmt_bind_param($stmt, "s", $email);
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
                    // Redirect to login page, retain email
                    header("Location: ../index.php?error=invalidpassword&email=".$email);
                    // Terminate script
                    exit();
                }
                // Login user
                else {
                    // Begin user session
                    session_start();
                    
                    // Declare global session variables passed from row
                    $_SESSION['userID'] = $row['userID'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    
                    // Redirect to dashboard page
                    header("Location: ../dashboard.php?login=success");
                    // Terminate script
                    exit();
                }
            } else {
                // Redirect to login page
                header("Location: ../index.php?error=invalidemail");
                // Terminate script
                exit();
            }
        }
    }
} else {
    // Redirect to login page
    header("Location: ../index.php");
    // Terminate script
    exit();
}