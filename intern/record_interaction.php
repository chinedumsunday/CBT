<?php
// record_interaction.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questionId'])) {
    // Get the question ID from the POST data
    $questionId = $_POST['questionId'];

    Replace this with your actual database handling logic
    $con = mysqli_connect('localhost','root','','project');
    $query = "UPDATE questions_table SET interaction_status = 1 WHERE question_id = $questionId";
    mysqli_query($con, $query);
    
    // Send a response (you can customize this message as needed)
    echo "Interaction recorded for question ID: " . $questionId;
} else {
    // Invalid request
    echo "Invalid request!";
}
?>
