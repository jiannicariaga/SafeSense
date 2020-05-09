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
        <title>SafeSense :: Activity Log</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon -->
        <link rel="icon" href="images/logo.png" type="image/gif">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="activity-log">
            <div class="activity">
                <!-- Header -->
                <h2>Activity Log</h2>
                <p>View device feedback here.</p>
                <hr>
                <!-- Activity Log -->
                <div id="log" class="form-group window scrollbar"></div>
            </div>
            <div class="footer row">
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
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            // Execute when document is loaded
            $(document).ready(function() {
                // Load data
                $("#log").load("includes/loaddata.inc.php", function() {
                    // Scroll to bottom of data
                    $("#log").scrollTop($("#log")[0].scrollHeight);
                });
                
                // Execute every 1 second
                setInterval(function() {
                    // Load data
                    $("#log").load("includes/loaddata.inc.php");
                }, 1000);
            });
        </script>
    </body>
</html>