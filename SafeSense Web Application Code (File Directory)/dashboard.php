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
        <title>SafeSense :: Dashboard</title>
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
        <div class="dashboard">
            <div class="modules">
                <!-- Header -->
                <h2>Dashboard</h2>
                <p>Welcome, <?php echo $_SESSION['username']; ?>.</p>
                <hr>
                <div>
                    <!-- Register Device Module -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Description -->
                                    <h5 class="card-title">Register Device</h5>
                                    <p class="card-text">Add a new SafeSense device.</p>
                                </div>
                                <div class="col-auto">
                                    <!-- Link to Register Device Page -->
                                    <a href="registerdevice.php">
                                        <button type="button" class="btn btn-primary module-btn">
                                            <!-- Icon -->
                                            <span class="fas fa-satellite-dish module-icon"></span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Activity Log Module -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Description -->
                                    <h5 class="card-title">Activity Log</h5>
                                    <p class="card-text">View device feedback.</p>
                                </div>
                                <div class="col-auto">
                                    <!-- Link to Activity Log Page -->
                                    <a href="activitylog.php">
                                        <button type="button" class="btn btn-primary module-btn">
                                            <!-- Icon -->
                                            <span class="fas fa-th-list module-icon"></span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Device Settings Module -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Description -->
                                    <h5 class="card-title">Device Settings</h5>
                                    <p class="card-text">Configure your devices.</p>
                                </div>
                                <div class="col-auto">
                                    <!-- Link to Device Settings Page -->
                                    <a href="devicesettings.php">
                                        <button type="button" class="btn btn-primary module-btn">
                                            <!-- Icon -->
                                            <span class="fas fa-sliders-h module-icon"></span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Account Settings Module -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Description -->
                                    <h5 class="card-title">Account Settings</h5>
                                    <p class="card-text">Configure your account.</p>
                                </div>
                                <div class="col-auto">
                                    <!-- Link to Account Settings Page -->
                                    <a href="accountsettings.php">
                                        <button type="button" class="btn btn-primary module-btn">
                                            <!-- Icon -->
                                            <span class="fas fa-user-cog module-icon"></span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- Log Out Button -->
            <form action="includes/logout.inc.php" method="post">
                <div class="text-center">
                    <button type="logout-submit" class="btn-link">Logout</button>
                </div>
            </form>
        </div>
    </body>
</html>