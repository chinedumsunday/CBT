<?php
include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
//delete feedback
if(isset($_SESSION['key'])){
if(@$_GET['fdid'] && $_SESSION['key']=='sunny7785068889') {
$id=@$_GET['fdid'];
$result = mysqli_query($con,"DELETE FROM feedback WHERE id='$id' ") or die('Error');
header("location:dash.php?q=3");
}
}

//delete user
if(isset($_SESSION['key'])){
if(@$_GET['demail'] && $_SESSION['key']=='sunny7785068889') {
$demail=@$_GET['demail'];
$r1 = mysqli_query($con,"DELETE FROM rank WHERE email='$demail' ") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM history WHERE email='$demail' ") or die('Error');
$result = mysqli_query($con,"DELETE FROM user WHERE email='$demail' ") or die('Error');
header("location:dash.php?q=1");
}
}
//remove quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'rmquiz' && $_SESSION['key']=='sunny7785068889') {
$eid=@$_GET['eid'];
$result = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' ") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$qid = $row['qid'];
$r1 = mysqli_query($con,"DELETE FROM options WHERE qid='$qid'") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM answer WHERE qid='$qid' ") or die('Error');
}
$r3 = mysqli_query($con,"DELETE FROM questions WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM quiz WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM history WHERE eid='$eid' ") or die('Error');

header("location:dash.php?q=5");
}
}

//add quiz
if(isset($_SESSION['key'])) {
  if(@$_GET['q'] == 'addquiz' && $_SESSION['key'] == 'sunny7785068889') {
      $name = $_POST['name'];
      $name = ucwords(strtolower($name));
      $total = $_POST['total'];
      $Right = $_POST['right'];
      $wrong = $_POST['wrong'];
      $time = $_POST['time'];
      $tag = $_POST['tag'];
      $desc = $_POST['desc'];
      $id = uniqid();
      $typ = $_POST['qns'.$i.'Select'];
      
      $q3 = mysqli_query($con, "INSERT INTO quiz VALUES ('$id','$name' , '$Right' , '$wrong','$total','$time' ,'$desc','$tag', NOW())");
      
      header("location:dash.php?q=4&step=2&eid=$id&n=$total");
  }

  if (@$_GET['q'] == 'addqns' && isset($_SESSION['key']) && $_SESSION['key'] == 'sunny7785068889') {
    $n = @$_GET['n'];
    $eid = @$_GET['eid'];
    $ch = @$_GET['ch'];

    for ($i = 1; $i <= $n; $i++) {
        // Retrieve question data from form fields
        $qid = uniqid();
        $qns = $_POST['qns' . $i];
        $typ = $_POST['qns'.$i.'Select']; // This will hold "objective" or "subjective"

        // Insert question into the database
        $q3 = mysqli_query($con, "INSERT INTO questions VALUES ('$eid','$qid','$qns' , '$ch' , '$i' , '$typ')");

        if (!$q3) {
            die("Error in Question Insertion: " . mysqli_error($con));
        }

        if ($typ == "objective") {
            // Insert options into the database
            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $a = $_POST['optionsA'.$i];
            $b = $_POST['optionsB'.$i];
            $c = $_POST['optionsC'.$i];
            $d = $_POST['optionsD'.$i];

            $qa = mysqli_query($con, "INSERT INTO options VALUES ('$qid','$a','$oaid')") or die('Error61');
            $qb = mysqli_query($con, "INSERT INTO options VALUES ('$qid','$b','$obid')") or die('Error62');
            $qc = mysqli_query($con, "INSERT INTO options VALUES ('$qid','$c','$ocid')") or die('Error63');
            $qd = mysqli_query($con, "INSERT INTO options VALUES ('$qid','$d','$odid')") or die('Error64');

            $e = $_POST['ans' . $i];
            switch ($e) {
                case 'a':
                    $ansid = $oaid;
                    break;
                case 'b':
                    $ansid = $obid;
                    break;
                case 'c':
                    $ansid = $ocid;
                    break;
                case 'd':
                    $ansid = $odid;
                    break;
                default:
                    $ansid = $oaid;
            }

            // Insert correct answer into the database
            $qans = mysqli_query($con, "INSERT INTO answer VALUES ('$qid','$ansid')");

            if (!$qans) {
                die("Error in Answer Insertion: " . mysqli_error($con));
            }
        } elseif ($typ == "subjective") { // Subjective type
            $subjectiveCorrect = $_POST["subjectiveCorrect" . $i];

            // Insert subjective question into the database
            //$q3 = mysqli_query($con, "INSERT INTO questions VALUES ('$eid','$qid','$qns' , '$ch' , '$i' , '$typ')");

            if (!$q3) {
                die("Error in Question Insertion: " . mysqli_error($con));
            }

            // Insert subjective answer into the database
            $oaid = uniqid();
            $qa = mysqli_query($con, "INSERT INTO options VALUES ('$qid','$subjectiveCorrect','$oaid')") or die('Error61');

            if (!$qa) {
                die("Error in Option Insertion: " . mysqli_error($con));
            }

            $e = $_POST["subjectiveCorrect" . $i];
            $ansid = $oaid;
            $qans = mysqli_query($con, "INSERT INTO answer VALUES ('$qid','$ansid')");

            if (!$qans) {
                die("Error in Answer Insertion: " . mysqli_error($con));
            }
        }
    }
    header("location:dash.php?q=0");
}
}


//quiz start
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];
    $qid = @$_GET['qid'];
    $ans = $_POST['ans'];
    $name = $_SESSION['name'];
    $email=$_SESSION['email'];
    $x = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'");
    while ($row = mysqli_fetch_array($x)){
      $title = $row['title'];
    }

    // Fetch the correct answers for the question from the database
    $correctAnswerQuery = mysqli_query($con, "SELECT options.option FROM options 
    JOIN answer ON options.optionid = answer.ansid 
    WHERE options.qid = '$qid'");
    $correctAnswerRow = mysqli_fetch_assoc($correctAnswerQuery);
    $correctAnswer = $correctAnswerRow['option'];

    // Split the correct answer into individual parts (assuming comma-separated)
    $correctAnswers = array_map('trim', explode(',', $correctAnswer));

    // Split the user's answer into individual parts (assuming comma-separated)
    $userAnswers = array_map('trim', explode(',', strtolower(trim($ans))));

    // Determine whether any of the user's answers are correct
    $isAnyAnswerCorrect = false;
    foreach ($userAnswers as $userAnswer) {
        if (in_array($userAnswer, $correctAnswers)) {
            $isAnyAnswerCorrect = true;
            break;
        }
    }
    if ($isAnyAnswerCorrect) {
        // Update the user's score for correct answer
        $q = mysqli_query($con, "SELECT Right FROM quiz WHERE eid='$eid'");
        $row = mysqli_fetch_assoc($q);
        $Right = $row['Right'];

        if ($sn == 1) {
            $q = mysqli_query($con, "INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW(), '$name', '$title')") or die('Error');
        }

        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error115');
        $row = mysqli_fetch_assoc($q);
        $s = $row['score'];
        $r = $row['Right'];

        $r++;
        $s = $s + $Right;
        $q = mysqli_query($con, "UPDATE `history` SET `score`=$s,`level`=$sn,`Right`=$r, date= NOW(), name = '$name', exam_title = '$title'  WHERE  email = '$email' AND eid = '$eid'") or die('Error124');
    } else {
        // Update the user's score for incorrect answer
        $q = mysqli_query($con, "SELECT wrong FROM quiz WHERE eid='$eid'") or die('Error129');
        $row = mysqli_fetch_assoc($q);
        $wrong = $row['wrong'];

        if ($sn == 1) {
            $q = mysqli_query($con, "INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW(), '$name', '$title')") or die('Error137');
        }

        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error139');
        $row = mysqli_fetch_assoc($q);
        $s = $row['score'];
        $w = $row['wrong'];

        $w++;
        $s = $s - $wrong;
        $q = mysqli_query($con, "UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW(), name = '$name', exam_title = '$title' WHERE  email = '$email' AND eid = '$eid'") or die('Error147');
    }

    if ($sn != $total) {
        $sn++;
        header("location:account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total") or die('Error152');
    } else if ($_SESSION['key'] != 'sunny7785068889') {
        $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error156');
        $row = mysqli_fetch_assoc($q);
        $s = $row['score'];
        $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
        $rowcount = mysqli_num_rows($q);
        if ($rowcount == 0) {
            $q2 = mysqli_query($con, "INSERT INTO rank VALUES('$email','$s',NOW())") or die('Error165');
        } else {
            $row = mysqli_fetch_assoc($q);
            $sun = $row['score'];
            $sun = $s + $sun;
            $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
        }
        header("location:account.php?q=result&eid=$eid");
    } else {
        header("location:account.php?q=result&eid=$eid");
    }
}

//restart quiz
if(@$_GET['q']== 'quizre' && @$_GET['step']== 25 ) {
$eid=@$_GET['eid'];
$n=@$_GET['n'];
$t=@$_GET['t'];
$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"DELETE FROM `history` WHERE eid='$eid' AND email='$email' " )or die('Error184');
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$sun-$s;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
header("location:account.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
}

?>



