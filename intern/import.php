<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (@$_GET['q'] == 'addqns' && isset($_SESSION['key']) && $_SESSION['key'] == 'sunny7785068889') {
        $n = @$_GET['n'];
        $eid = @$_GET['eid'];
        $ch = @$_GET['ch'];


        if (($handle = fopen($file, "r")) !== false) {
            $con = new mysqli("localhost", "root", "", "project") or die("Could not connect to mysql" . mysqli_error($con));

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                // Assuming $eid, $choice, $sn are initialized elsewhere
                $sn = $data[0]
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
                $eid = $eid;
                $ch = $ch;


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
}
?>
