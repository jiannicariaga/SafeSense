<?php
// Check if sign up button was clicked
if (isset($_POST['signup-submit'])) {
    
    // Include database handler
    require 'dbh.inc.php';
    
    // Declare names passed via HTTP POST
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];
    $checkbox = $_POST['checkbox'];
    
    // Check if any field is empty
    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm) || empty($checkbox)) {
        // Redirect to sign up page, retain username and email
        header("Location: ../signup.php?error=emptyfields&username=".$username."&email=".$email);
        // Terminate script
        exit();
    }
    // Check if username and email are invalid
    else if (!preg_match("/[a-zA-Z\d_-]{5,15}/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect to sign up page
        header("Location: ../signup.php?error=invalidusernameemail");
        // Terminate script
        exit();
    }
    // Check if username is invailid
    else if (!preg_match("/[a-zA-Z\d_-]{5,15}/", $username)) {
        // Redirect to sign up page, retain email
        header("Location: ../signup.php?error=invalidusername&email=".$email);
        // Terminate script
        exit();
    }
    // Check if email is invalid
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect to sign up page, retain username
        header("Location: ../signup.php?error=invalidemail&username=".$username);
        // Terminate script
        exit();
    }
    // Check if password is invalid
    else if (!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/", $password)) {
        // Redirect to sign up page, retain username and email
        header("Location: ../signup.php?error=invalidpassword&username=".$username."&email=".$email);
        // Terminate script
        exit();
    }
    // Check if passwords do not match
    else if ($password !== $passwordConfirm) {
        // Redirect to sign up page, retain username and email
        header("Location: ../signup.php?error=passwordsdonotmatch&username=".$username."&email=".$email);
        // Terminate script
        exit();
    }
    // Check if email already exists in database
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
            // Bind email to prepared statement
            mysqli_stmt_bind_param($stmt, "s", $email);
            // Execute prepared statement in database
            mysqli_stmt_execute($stmt);
            // Store result from database
            mysqli_stmt_store_result($stmt);
            // Return number of rows and store from result
            $rows = mysqli_stmt_num_rows($stmt);
            
            // Check if rows exist
            if ($rows > 0) {
                // Redirect to sign up page, retain username
                header("Location: ../signup.php?error=emailused&username=".$username);
                // Terminate script
                exit();
            }
            // Insert form data into database
            else {
                // Initialize query
                $sql = "INSERT INTO users (username, email, password) VALUE (?, ?, ?)";
                // Initialize statement
                $stmt = mysqli_stmt_init($conn);

                // Check if prepared statement failed 
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    // Redirect to sign up page
                    header("Location: ../signup.php?error=sqlerror");
                    // Terminate script
                    exit();
                } else {
                    // Hash password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    // Bind username, email, and hashed password to prepared statement
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
                    // Execute prepared statement in database
                    mysqli_stmt_execute($stmt);
                    
                    // Redirect to login page
                    header("Location: ../index.php?signup=success");
                    // Terminate script
                    exit();
                }
            }
        }
    }
} else {
    // Redirect to sign up page
    header("Location: ../signup.php");
    // Terminate script
    exit();
}