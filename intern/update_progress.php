<?php
// update_progress.php
session_start();

if (isset($_POST['questionNumber'])) {
    $questionNumber = $_POST['questionNumber'];
    $_SESSION['answered_questions'][] = $questionNumber;
    // You can also update the database here if needed
    echo 'success';
} else {
    echo 'error';
}
?>
