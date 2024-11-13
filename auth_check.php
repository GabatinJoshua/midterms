<?php
// Include functions.php only once
require_once('functions.php');
guard(); // Ensure the user is logged in

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
