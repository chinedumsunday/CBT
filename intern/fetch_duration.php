<?php

$con = new new mysqli('localhost','root','','project')or die("Could not connect to mysql".mysqli_error($con));

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch duration from the database
$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $duration = $row["time"];
    echo $duration;
} else {
    echo "0";
}

$conn->close();
?>
