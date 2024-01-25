<?php
// Start or resume a session
session_start();

// Check if the 'email' session variable is set
if (isset($_SESSION['email'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Redirect the user to the 'index.php' page
header("Location: ../index.php");

// Terminate the script execution
exit;
?>
