<?php
// Start or resume a session
session_start();
// Check if the 'email' key is not set in the session
if(!isset($_SESSION['email'])) {
   // If 'email' is not set, redirect the user to the 'index.php' page
   header("location: index.php");
}

?>
