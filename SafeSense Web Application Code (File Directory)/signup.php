<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SafeSense :: Sign Up</title>
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
            <form action="includes/signup.inc.php" method="post">
                <!-- Header -->
                <h2>Sign Up</h2>
                <p class="caption">You will need to login after signing up.</p>
                <hr>
                <!-- Username Field -->
                <div class="form-group">
                    <div class="input-group">
                        <!-- Icon -->
                        <span class="input-group-prepend">
                            <span class="input-group-text"><span class="fas fa-user form-icon"></span></span>
                        </span>
                        <!-- Input -->
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo isset($_GET['username']) ? htmlentities($_GET["username"]) : ''; ?>">
                    </div>
                    <!-- Requirements -->
                    <div id="user-req">
                        <p>Username may contain the following:</p>
                        <p id="user-chars" class="invalid">Letters, numbers, underscores, or dashes</p>
                        <p id="user-length" class="invalid">Minimum 5 characters (maximum 15)</p>
                    </div>
                </div>
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
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <!-- Requirements -->
                    <div id="pass-req">
                        <p>Password must include the following:</p>
                        <p id="pass-lower" class="invalid">At least 1 lowercase letter</p>
                        <p id="pass-upper" class="invalid">At least 1 uppercase letter</p>
                        <p id="pass-number" class="invalid">At least 1 number</p>
                        <p id="pass-minlength" class="invalid">Minimum 8 characters</p>
                    </div>
                </div>
                <!-- Confirm Password Field -->
                <div class="form-group">
                    <div class="input-group">
                        <!-- Icon -->
                        <span class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-lock form-icon"></span><span class="fas fa-check"></span>
                            </span>
                        </span>
                        <!-- Input -->
                        <input type="password" name="password-confirm" id="password-confirm" class="form-control" placeholder="Confirm Password">
                    </div>
                    <!-- Requirements -->
                    <div id="pass-match">
                        <p id="match-true" class="valid">Passwords match</p>
                        <p id="match-false" class="invalid">Passwords do not match</p>
                    </div>
                </div>
                <!-- Terms of Use & Privacy Policy -->
                <div class="form-group">
                    <label class="checkbox-inline">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="checkbox" id="remember-me" class="custom-control-input"> 
                            <label class="custom-control-label" for="remember-me">I accept the <a href="termsofuse.php">Terms of Use</a> &amp; <a href="privacypolicy.php">Privacy Policy</a></label>
                        </div>
                    </label>
                </div>
                <!-- Sign Up Button -->
                <div class="form-group">
                    <button type="submit" name="signup-submit" class="btn btn-primary btn-lg login-signup-btn">Sign Up</button>
                    <!-- Error Messages -->
                    <?php
                    // Check if form has an error
                    if (isset($_GET['error'])) {
                        // Check if any fields were left empty
                        if ($_GET['error'] == 'emptyfields') {
                            // Display error message
                            echo '<small class="invalid form-feedback">Please fill out entire form.</small>';
                        }
                        // Check if username and email are invalid
                        else if ($_GET['error'] == 'invalidusernameemail') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid username and email.</small>';
                        }
                        // Check if username is invalid
                        else if ($_GET['error'] == 'invalidusername') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid username.</small>';
                        }
                        // Check if email is invalid
                        else if ($_GET['error'] == 'invalidemail') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid email.</small>';
                        }
                        // Check if password is invalid
                        else if ($_GET['error'] == 'invalidpassword') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid password.</small>';
                        }
                        // Check if passwords do not match
                        else if ($_GET['error'] == 'passwordsdonotmatch') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Passwords do not match.</small>';
                        }
                        // Check if email is already used
                        else if ($_GET['error'] == 'emailused') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Email already used.</small>';
                        }
                        // Check if database connection failed
                        else if ($_GET['error'] == 'sqlerror') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Database connection failed.</small>';
                        }
                    }
                    ?>
                </div>
            </form>
            <!-- Link to Login Page -->
            <div class="footer text-center">Already have an account? <a href="index.php">Login</a></div>
        </div>
        <!-- Username Validation -->
        <script src="js/checkuser.js"></script>
        <!-- Password Validation -->
        <script src="js/checkpass.js"></script>
        <!-- Password Confirm Validation -->
        <script src="js/matchpass.js"></script>
    </body>
</html>