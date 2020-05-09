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
        <title>SafeSense :: Register Device</title>
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
        <div class="register-device-form">
            <form action="includes/regdevice.inc.php" method="post" id="registration">
                <!-- Header -->
                <h2>Register Device</h2>
                <p>Add a new SafeSense device here.</p>
                <hr>
                <!-- Instructions -->
                <div class="form-group">
                    <h5 class="card-title">Instructions</h5>
                    <ol class="instructions">
                        <li class="steps">Connect your SafeSense device to your computer using the provided USB-to-Micro USB cable.</li>
                        <li class="steps step2">Install and run <a href="#" class="software">SafeSense Toolbox</a> on your computer.</li>
                        <li class="steps step3">Enter your home Wi-Fi credentials to connect your SafeSense device to the internet.</li>
                        <li class="steps">Enter the authentication key found on the device below to register your device.</li>
                    </ol>
                </div>
                <!-- Authentication Key Field -->
                <div class="form-group">
                    <div class="input-group">
                        <!-- Icon -->
                        <span class="input-group-prepend">
                            <span class="input-group-text"><span class="fas fa-key form-icon"></span></span>
                        </span>
                        <!-- Input -->
                        <input type="text" name="auth-key" class="form-control" placeholder="Authentication Key">
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
                <!-- Register Button -->
                <div class="form-group">
                    <button type="submit" name="reg-submit" class="btn btn-primary btn-lg register-device-btn">Register</button>
                    <!-- Error/Success Messages -->
                    <?php
                    // Check if form has an error
                    if (isset($_GET['error'])) {
                        // Check if any fields were left empty
                        if ($_GET['error'] == 'rd_emptyfields') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Please fill out entire form.</small>';
                        }
                        // Check if password is invalid
                        else if ($_GET['error'] == 'rd_invalidpassword') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Invalid password.</small>';
                        }
                        // Check if new device matches current device(s)
                        else if ($_GET['error'] == 'rd_samedevice') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Same device.</small>';
                        }
                        // Check if device is not found
                        else if ($_GET['error'] == 'rd_devicenotfound') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Device not found.</small>';
                        }
                        // Check if database connection failed
                        else if ($_GET['error'] == 'rd_sqlerror') {
                            // Display error message
                            echo '<small class="form-feedback invalid">Database connection failed.</small>';
                        }
                    }
                    
                    // Check if device is registered
                    if (isset($_GET['registerdevice'])) {
                        // Check if all fields were filled out correctly
                        if ($_GET['registerdevice'] == 'success') {
                            // Display success message
                            echo '<small class="form-feedback valid">Device registration successful.</small>';
                        }
                    }
                    ?>
                </div>
            </form>
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
    </body>
</html>