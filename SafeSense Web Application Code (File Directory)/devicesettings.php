<?php
    // Begin user session
    session_start();
    // Check if user is logged out
    if (!isset($_SESSION['userID'])) {
        // Redirect to login page
        header("Location: /SafeSense/index.php?error=unauthorized");
    } else {
        // Include database handler
        require 'includes/dbh.inc.php';
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SafeSense :: Device Settings</title>
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
        <div class="device-settings">
            <div class="settings">
                <!-- Header -->
                <h2>Device Settings</h2>
                <p>Configure your devices here.</p>
                <hr>
                <?php
                // Initialize query
                $sql = "SELECT * FROM devices WHERE userID=?";
                // Initialize statement
                $stmt = mysqli_stmt_init($conn);

                // Check if prepared statement failed 
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    // Redirect to login page
                    header("Location: index.php?error=sqlerror");
                    // Terminate script
                    exit();
                } else {
                    // Bind user ID to prepared statement
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
                    // Execute prepared statement in database
                    mysqli_stmt_execute($stmt);
                    // Get and store result from database
                    $result = mysqli_stmt_get_result($stmt);   
                }
                
                // Check if row exists
                if ($row = mysqli_fetch_assoc($result)) { 
                ?>
                <!-- Device Card -->
                <div class="card">
                    <!-- Device Name/Location Form -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col device-info">
                                <h5 class="device-name"><?php echo $row['deviceName']; ?> <label class="device-location"><?php echo $row['deviceLocation']; ?></label></h5>
                            </div>
                            <div class="col device-edit">
                                <small><a href="javascript:editDevice()" class="edit">Edit</a></small>
                            </div>
                        </div>
                        <!-- Edit Device Form -->
                        <form action="includes/editdevice.inc.php" method="post" id="change-device">
                            <!-- New Name Field -->
                            <div class="form-group">
                                <div class="input-group">
                                    <!-- Icon -->
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><span class="fas fa-microchip form-icon"></span></span>
                                    </span>
                                    <!-- Input -->
                                    <input type="text" name="new-name" id="name" class="form-control" placeholder="New Device Name" value="<?php echo isset($_GET["newname"]) ? htmlentities($_GET["newname"]) : ''; ?>">
                                </div>
                                <!-- Requirements -->
                                <div id="name-req">
                                    <p>New device name may contain the following:</p>
                                    <p id="name-chars" class="invalid">Letters, numbers, spaces, underscores, dashes, or apostrophes</p>
                                    <p id="name-length" class="invalid">Minimum 1 charcter (maximum 10)</p>
                                </div>
                            </div>
                            <!-- New Location Field -->
                            <div class="form-group">
                                <div class="input-group">
                                    <!-- Icon -->
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><span class="fas fa-map-marker-alt form-icon"></span></span>
                                    </span>
                                    <!-- Input -->
                                    <input type="text" name="new-location" id="location" class="form-control" placeholder="New Device Location" value="<?php echo isset($_GET["newlocation"]) ? htmlentities($_GET["newlocation"]) : ''; ?>">
                                </div>
                                <!-- Requirements -->
                                <div id="location-req">
                                    <p>New device location may contain the following:</p>
                                    <p id="location-chars" class="invalid">Letters, numbers, spaces, underscores, dashes, or apostrophes</p>
                                    <p id="location-length" class="invalid">Minimum 1 charcter (maximum 10)</p>
                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="form-group">
                                <button type="submit" name="edit-submit" class="btn btn-primary btn-lg edit-device-btn">Save</button>
                                <!-- Error/Success Message -->
                                <?php
                                // Check if form has an error
                                if (isset($_GET['error'])) {
                                    // Check if any fields were left empty
                                    if ($_GET['error'] == 'ed_emptyfields') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Please fill out at least one field.</small>';
                                    }
                                    // Check if new name is invalid
                                    else if ($_GET['error'] == 'ed_invalidnewname') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Invalid new name.</small>';
                                    }
                                    // Check if new name matches current name
                                    else if ($_GET['error'] == 'ed_samename') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Same name.</small>';
                                    }
                                    // Check if new location is invalid
                                    else if ($_GET['error'] == 'ed_invalidnewlocation') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Invalid new location.</small>';
                                    }
                                    // Check if new location matches current location
                                    else if ($_GET['error'] == 'ed_samelocation') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Same location.</small>';
                                    }
                                    // Check if new name and location are invalid
                                    else if ($_GET['error'] == 'ed_invalidnewnameandlocation') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Invalid new name and location.</small>';
                                    }
                                    // Check if new name and location matches current name and location
                                    else if ($_GET['error'] == 'ed_samenameandlocation') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Same name and location.</small>';
                                    }
                                    // Check if database connection failed
                                    else if ($_GET['error'] == 'ed_sqlerror') {
                                        // Display error message
                                        echo '<small class="form-feedback invalid">Database connection failed.</small>';
                                    }
                                }

                                // Check if device name or location changed
                                if (isset($_GET['editdevice'])) {
                                    // Check if all fields were filled out correctly
                                    if ($_GET['editdevice'] == 'success') {
                                        // Display success message
                                        echo '<small class="form-feedback valid">Device updated.</small>';
                                    }
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                    <!-- Device Settings Form -->
                    <form action="includes/setdevice.inc.php" method="post">
                        <div class="card-body">
                            <!-- Max Range -->
                            <h6 class="card-title">Maximum Range <small>(Value: <span id="range-value"></span>m)</small></h6>
                            <div class="form-group">
                                <div class="row settings-row">
                                    <div class="col slider-range">
                                        <label>0.66m</label>
                                    </div>
                                    <div class="col slide-container">
                                        <!-- Input (0.66m - 10.2m) -->
                                        <input type="range" name="max-range" min="0.66" max="10.2" step="0.01" value="<?php echo $row['maxRange']; ?>" id="range-input" class="slider">
                                    </div>
                                    <div class="col slider-range">
                                        <label>10.2m</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Sensitivity -->
                            <h6 class="card-title">Sensitivity</h6>
                            <div class="form-group">
                                <div class="row settings-row">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <!-- Input (Low) -->
                                        <input class="custom-control-input" type="radio" name="sensitivity" id="low" value="l" <?php echo ($row['sensitivity'] == 'l') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="low">Low</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <!-- Input (Medium) -->
                                        <input class="custom-control-input" type="radio" name="sensitivity" id="medium" value="m" <?php echo ($row['sensitivity'] == 'm') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="medium">Medium</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <!-- Input (High) -->
                                        <input class="custom-control-input" type="radio" name="sensitivity" id="high" value="h" <?php echo ($row['sensitivity'] == 'h') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="high">High</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Show Activity -->
                            <h6 class="card-title">Show Activity</h6>
                            <div class="form-group">
                                <div class="row settings-row">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <!-- Input (On) -->
                                        <input class="custom-control-input" type="radio" name="show-activity" id="on" value="on" <?php echo ($row['showActivity'] == 'on') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="on">On</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <!-- Input (Off) -->
                                        <input class="custom-control-input" type="radio" name="show-activity" id="off" value="off" <?php echo ($row['showActivity'] == 'off') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="off">Off</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Save Button -->
                        <div id="set-submit" class="form-group">
                            <button type="submit" name="set-submit" class="btn btn-primary btn-lg set-device-btn">Save</button>
                            <!-- Error/Success Messages -->
                            <?php
                            // Check if form has an error
                            if (isset($_GET['error'])) {
                                // Check if new settings match current settings
                                if ($_GET['error'] == 'sd_samesettings') {
                                    // Display error message
                                    echo '<small class="form-feedback invalid">Same settings.</small>';
                                }
                                // Check if database connection failed
                                else if ($_GET['error'] == 'sd_sqlerror') {
                                    // Display error message
                                    echo '<small class="form-feedback invalid">Database connection failed.</small>';
                                }
                            }
                            // Check if settings are saved
                            if (isset($_GET['editsettings'])) {
                                // Check if all fields were filled out correctly
                                if ($_GET['editsettings'] == 'success') {
                                    // Display success message
                                    echo '<small class="form-feedback valid">Settings updated.</small>';
                                }
                            }
                            ?>
                        </div>
                    </form>
                </div>
                <?php } else { ?>
                <!-- Message -->
                <div class="form-group no-devices">
                    <p>No device connected.</p>
                    <p>Add a new SafeSense device <a href="registerdevice.php" class="redirect">here</a>.</p>
                </div>
                <?php } ?>
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
        <!-- Device Name Validation -->
        <script src="js/checkname.js"></script>
        <!-- Device Location Validation -->
        <script src="js/checkloca.js"></script>
        <!-- Max Range Slider -->
        <script src="js/slider.js"></script>
    </body>
</html>