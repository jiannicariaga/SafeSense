<?php
    // Begin user session
    session_start();
    // Check if user is logged out
    if (!isset($_SESSION['userID'])) {
        // Redirect to login page
        header("Location: /SafeSense/index.php?error=unauthorized");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SafeSense :: Account Settings</title>
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
        <div class="account-settings">
            <div class="settings">
                <!-- Header -->
                <h2>Account Settings</h2>
                <p>Configure your account here.</p>
                <hr>
                <!-- User Profile Module -->
                <h5 class="card-title">Your Profile</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Label Column -->
                            <div class="col profile-label">
                                <p class="card-text">Username</p>
                                <p class="card-text">Email</p>
                                <p class="card-text">Password</p>
                            </div>
                            <!-- Information Column -->
                            <div class="col profile-info">
                                <p class="card-text"><?php echo $_SESSION['username']; ?></p>
                                <p class="card-text overflow"><?php echo $_SESSION['email']; ?></p>
                                <p class="card-text">********</p>
                            </div>
                            <!-- Edit Column -->
                            <div class="col profile-edit">
                                <p><a href="javascript:editUsername()">Edit</a></p>
                                <p><a href="javascript:editEmail()">Edit</a></p>
                                <p><a href="javascript:editPassword()">Edit</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Username Form -->
                <form action="includes/edituser.inc.php" method="post" id="change-username">
                    <h5 class="card-title">Edit Username</h5>
                    <!-- New Username Field -->
                    <div class="form-group">
                        <div class="input-group">
                            <!-- Icon -->
                            <span class="input-group-prepend">
                                <span class="input-group-text"><span class="fas fa-user form-icon"></span></span>
                            </span>
                            <!-- Input -->
                            <input type="text" name="new-username" id="username" class="form-control" placeholder="New Username" value="<?php echo isset($_GET["newusername"]) ? htmlentities($_GET["newusername"]) : ''; ?>">
                        </div>
                        <!-- Requirements -->
                        <div id="user-req">
                            <p>New username may contain the following:</p>
                            <p id="user-chars" class="invalid">Letters, numbers, underscores, or dashes</p>
                            <p id="user-length" class="invalid">Minimum 5 characters (maximum 15)</p>
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
                    </div>
                    <!-- Save Button -->
                    <div class="form-group">
                        <button type="submit" name="user-submit" class="btn btn-primary btn-lg save-profile-btn">Save</button>
                        <!-- Error/Success Message -->
                        <?php
                        // Check if form has an error
                        if (isset($_GET['error'])) {
                            // Check if any fields were left empty
                            if ($_GET['error'] == 'eu_emptyfields') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Please fill out entire form.</small>';
                            }
                            // Check if new username matches current username
                            else if ($_GET['error'] == 'eu_sameusername') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Same username.</small>';
                            }
                            // Check if new username is invalid
                            else if ($_GET['error'] == 'eu_invalidnewusername') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid username.</small>';
                            }
                            // Check if password is invalid
                            else if ($_GET['error'] == 'eu_invalidpassword') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid password.</small>';
                            }
                            // Check if database connection failed
                            else if ($_GET['error'] == 'eu_sqlerror') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Database connection failed.</small>';
                            }
                        }
                        
                        // Check if username changed
                        if (isset($_GET['editusername'])) {
                            // Check if all fields were filled out correctly
                            if ($_GET['editusername'] == 'success') {
                                // Display success message
                                echo '<small class="form-feedback valid">Username updated.</small>';
                            }
                        }
                        ?>
                    </div>
                </form>
                <!-- Edit Email Form -->
                <form action="includes/editemail.inc.php" method="post" id="change-email">
                    <h5 class="card-title">Edit Email</h5>
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
                    <!-- New Email Field -->
                    <div class="form-group">
                        <div class="input-group">
                            <!-- Icon -->
                            <span class="input-group-prepend">
                                <span class="input-group-text"><span class="fas fa-paper-plane form-icon"></span></span>
                            </span>
                            <!-- Input -->
                            <input type="text" name="new-email" class="form-control" placeholder="New Email Address" value="<?php echo isset($_GET["newemail"]) ? htmlentities($_GET["newemail"]) : ''; ?>">
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
                    </div>
                    <!-- Save Button -->
                    <div class="form-group">
                        <button type="submit" name="email-submit" class="btn btn-primary btn-lg save-profile-btn">Save</button>
                        <!-- Error/Success Message -->
                        <?php
                        // Check if form has an error
                        if (isset($_GET['error'])) {
                            // Check if any fields were left empty
                            if ($_GET['error'] == 'ee_emptyfields') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Please fill out entire form.</small>';
                            }
                            // Check if current email is invalid
                            else if ($_GET['error'] == 'ee_invalidemail') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid email.</small>';
                            }
                            // Check if new new email matches current email
                            else if ($_GET['error'] == 'ee_sameemail') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Same email.</small>';
                            }
                            // Check if new email is invalid
                            else if ($_GET['error'] == 'ee_invalidnewemail') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid new email.</small>';
                            }
                            // Check if new email is already used
                            else if ($_GET['error'] == 'ee_newemailused') {
                                // Display error message
                                echo '<small class="form-feedback invalid">New email already used.</small>';
                            }
                            // Check if password is invalid
                            else if ($_GET['error'] == 'ee_invalidpassword') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid password.</small>';
                            }
                            // Check if database connection failed
                            else if ($_GET['error'] == 'ee_sqlerror') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Database connection failed.</small>';
                            }
                        }

                        // Check if email changed
                        if (isset($_GET['editemail'])) {
                            // Check if all fields were filled out correctly
                            if ($_GET['editemail'] == 'success') {
                                // Display success message
                                echo '<small class="form-feedback valid">Email updated.</small>';
                            }
                        }
                        ?>
                    </div>
                </form>
                <!-- Edit Password Form -->
                <form action="includes/editpass.inc.php" method="post" id="change-password">
                    <h5 class="card-title">Edit Password</h5>
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
                    </div>
                    <!-- New Password Field -->
                    <div class="form-group">
                        <div class="input-group">
                            <!-- Icon -->
                            <span class="input-group-prepend">
                                <span class="input-group-text"><span class="fas fa-lock form-icon"></span></span>
                            </span>
                            <!-- Input -->
                            <input type="password" name="new-password" id="password" class="form-control" placeholder="New Password">
                        </div>
                        <!-- Requirements -->
                        <div id="pass-req">
                            <p>New password must include the following:</p>
                            <p id="pass-lower" class="invalid">At least 1 lowercase letter</p>
                            <p id="pass-upper" class="invalid">At least 1 uppercase letter</p>
                            <p id="pass-number" class="invalid">At least 1 number</p>
                            <p id="pass-minlength" class="invalid">Minimum 8 characters</p>
                        </div>
                    </div>
                    <!-- Confirm New Password Field -->
                    <div class="form-group">
                        <div class="input-group">
                            <!-- Icon -->
                            <span class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-lock form-icon"></span><span class="fas fa-check"></span>
                                </span>
                            </span>
                            <!-- Input -->
                            <input type="password" name="new-password-confirm" id="password-confirm" class="form-control" placeholder="Confirm New Password">
                        </div>
                        <!-- Requirements -->
                        <div id="pass-match">
                            <p id="match-true" class="valid">Passwords match</p>
                            <p id="match-false" class="invalid">Passwords do not match</p>
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="form-group">
                        <button type="submit" name="pass-submit" class="btn btn-primary btn-lg save-profile-btn">Save</button>
                        <!-- Error/Success Message -->
                        <?php
                        // Check if form has an error
                        if (isset($_GET['error'])) {
                            // Check if any fields were left empty
                            if ($_GET['error'] == 'ep_emptyfields') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Please fill out entire form.</small>';
                            }
                            // Check if current password is invalid
                            else if ($_GET['error'] == 'ep_invalidpassword') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid password.</small>';
                            }
                            // Check if new password matches current password
                            else if ($_GET['error'] == 'ep_samepassword') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Same password.</small>';
                            }
                            // Check if new password is invalid
                            else if ($_GET['error'] == 'ep_invalidnewpassword') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Invalid new password.</small>';
                            }
                            // Check if passwords do not match
                            else if ($_GET['error'] == 'ep_passwordsdonotmatch') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Passwords do not match.</small>';
                            }
                            // Check if database connection failed
                            else if ($_GET['error'] == 'ep_sqlerror') {
                                // Display error message
                                echo '<small class="form-feedback invalid">Database connection failed.</small>';
                            }
                        }

                        // Check if password changed
                        if (isset($_GET['editpassword'])) {
                            // Check if all fields were filled out correctly
                            if ($_GET['editpassword'] == 'success') {
                                // Display success message
                                echo '<small class="form-feedback valid">Password updated.</small>';
                            }
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Dashboard Button -->
                    <div class="text-left">
                        <a href="dashboard.php">
                            <button type="button" class="btn-link">Dashboard</button>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <!-- Log Out Button -->
                    <form action="includes/logout.inc.php" method="post">
                        <div class="text-right">
                            <button type="logout-submit" class="btn-link">Logout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Display Edit Forms -->
        <script src="js/dispform.js"></script>
        <!-- Username Validation -->
        <script src="js/checkuser.js"></script>
        <!-- Password Validation -->
        <script src="js/checkpass.js"></script>
        <!-- Password Confirm Validation -->
        <script src="js/matchpass.js"></script>
    </body>
</html>