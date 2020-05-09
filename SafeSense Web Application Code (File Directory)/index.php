<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SafeSense :: Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon -->
        <link rel="icon" href="images/logo.png" type="image/gif">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/d4d2fc7ab9.js" crossorigin="anonymous"></script>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="login-signup-form">
            <form action="includes/login.inc.php" method="post">
                <!-- Header -->
                <h2>SafeSense Login</h2>
                <p>Manage your SafeSense devices here.</p>
                <hr>
                <!-- Email Field -->
                <div class="form-group">
                    <div class="input-group">
                        <!-- Icon -->
                        <span class="input-group-prepend">
                            <span class="input-group-text"><span class="fas fa-paper-plane form-icon"></span></span>
                        </span>
                        <!-- Input -->
                        <input type="text" name="email" class="form-control" placeholder="Email Address" value="<?php echo isset($_GET["email"]) ? htmlentities($_GET["email"]) : ''; ?>">
                    </div>
                </div>
                <!-- Password Field -->
                <div class="form-group">
                    <div class="input-group">
                        <!-- Icon -->
                        <span class="input-group-prepend">
                            <span class="input-group-text"><span class="fas fa-lock form-icon"></span></span>
                        </span>
                        <!-- Input -->
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <!-- Forgot password? -->
                    <!-- <small class="form-text"><a href="#">Forgot password?</a></small> -->
                </div>
                <!-- Remember Me -->
                <!--
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="remember-me" class="custom-control-input"> 
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                </div>
                -->
                <!-- Login Button -->
                <div class="form-group">
                    <button type="submit" name="login-submit" class="btn btn-primary btn-lg login-signup-btn">Login</button>
                    <!-- Error/Success Messages -->
                    <?php
                    // Check if form has an error
                    if (isset($_GET['error'])) {
                        // Check if any fields were left empty
                        if ($_GET['error'] == 'emptyfields') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Please fill out entire form.</small>';
                        }
                        // Check if password is invalid
                        else if ($_GET['error'] == 'invalidpassword') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid password.</small>';
                        }
                        // Check if email is invalid
                        else if ($_GET['error'] == 'invalidemail') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid email.</small>';
                        }
                        // Check if database connection failed
                        else if ($_GET['error'] == 'sqlerror') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Database connection failed.</small>';
                        }
                        // Check if user 
                        else if ($_GET['error'] == 'unauthorized') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Login to access features.</small>';
                        }
                    }
                    
                    // Check if user signed up
                    if (isset($_GET['signup'])) {
                        // Check if all fields were filled out correctly
                        if ($_GET['signup'] == 'success') {
                            // Display success message
                            echo '<small class="form-feedback valid">Sign up successful.</small>';
                        }
                    }
                    
                    // Check if user logged out
                    if (isset($_GET['logout'])) {
                        // Check if all fields were filled out coorectly
                        if ($_GET['logout'] == 'success') {
                            // Display success message
                            echo '<small class="form-feedback valid">Log out successful.</small>';
                        }
                    }
                    ?>
                </div>
            </form>
            <!-- Link to Sign Up Page -->
            <div class="footer text-center">Don't have an account? <a href="signup.php">Sign Up</a>
            </div>
        </div>
    </body>
</html>