<?php
// Start the session
session_start();

// Set the active tab in session
if(isset($_GET['activeReviewTab'])) {
    $_SESSION['activeReviewTab'] = $_GET['activeReviewTab'];
    echo 'success';
} else {
    echo 'error';
}
?>