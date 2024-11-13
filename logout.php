<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session to log the user out
session_destroy();

// Redirect to the login page after logout
header("Location: index.php");
exit;
?>
