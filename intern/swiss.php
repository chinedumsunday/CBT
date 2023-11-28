<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"]) && isset($_POST['eid'])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== false) {
        $con = new mysqli("localhost", "root", "", "project") or die("Could not connect to mysql" . mysqli_error($con));

        $isFirstRow = true; // Flag to indicate the first row

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if ($isFirstRow) {
                $isFirstRow = false; // Skip the first row
                continue; // Skip processing this iteration
            }

            $sn = $data[0];
            $questionText = $data[1];
            $optionA = $data[2];
            $optionB = $data[3];
            $optionC = $data[4];
            $optionD = $data[5];
            $correctOption = $data[6];
            $qid = uniqid();
            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $question_type = $data[7];
            $choice = $data[8];
            $eid = $_POST['eid'];


            $sql = "INSERT INTO questions (eid, qid, qns, choice, sn, question_type) VALUES ('$eid', '$qid', '$questionText', '$choice', '$sn', '$question_type')";
            mysqli_query($con, $sql);

            if ($question_type == "objective") {
                mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$optionA', '$oaid')") or die("Error61");
                mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$optionB', '$obid')") or die("Error62");
                mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$optionC', '$ocid')") or die("Error63");
                mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$optionD', '$odid')") or die("Error64");

                if ($correctOption == $optionA) {
                    $ansid = $oaid;
                } elseif ($correctOption == $optionB) {
                    $ansid = $obid;
                } elseif ($correctOption == $optionC) {
                    $ansid = $ocid;
                } else {
                    $ansid = $odid;
                }

                mysqli_query($con, "INSERT INTO answer VALUES ('$qid', '$ansid')");
            } elseif ($question_type == "subjective") {
                mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$correctOption', '$oaid')") or die("Error61");
                $ansid = $oaid;
                mysqli_query($con, "INSERT INTO answer VALUES ('$qid', '$ansid')");
            }
        }

        fclose($handle);
        echo "Questions imported successfully!";
    } else {
        echo "Error reading the CSV file.";
    }
}
?>
