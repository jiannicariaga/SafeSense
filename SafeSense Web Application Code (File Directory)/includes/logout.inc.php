<?php
// Begin user session
session_start();
// Remove all session variables
session_unset();
// End user session
session_destroy();
// Redirect to login page
header("Location: ../index.php?logout=success");