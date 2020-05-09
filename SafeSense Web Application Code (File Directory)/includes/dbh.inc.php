<?php
// Declare database credentials (Local)
$servername = "";
$dBUsername = "";
$dBPassword = "";
$dBName = "";

// Declare database credentials (SiteGround)
// $servername = "";
// $dBUsername = "";
// $dBPassword = "";
// $dBName = "";

// Create database connection
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

// Check if connection failed
if (!$conn) {
    // Display error
    die("Connection failed: ".mysqli_connect_error());
}