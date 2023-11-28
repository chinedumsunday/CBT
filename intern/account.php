<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CBT</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

 
  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
 <!--alert message-->
<?php
ob_start();
if(@$_GET['w'])
{echo'<script>alert("'.@$_GET['w'].'");</script>';}
?>
<!--alert message end-->

</head>
<?php
include_once 'dbConnection.php';
?>
<body>
<div class="header">
<div class="row">
<div class="col-lg-6" , style="width:100%">
<span class="logo">Computer Based Test</span></div>
<div class="col-md-4 col-md-offset-2">
 <?php
 include_once 'dbConnection.php';
session_start();
  if(!(isset($_SESSION['email']))){
header("location:index.php");

}
else
{
$name = $_SESSION['name'];
$email=$_SESSION['email'];

// include_once 'dbConnection.php';
// echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;</span> <a href="account.php?q=1" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>
</div>
</div></div>
<div class="bg">

<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?> ><a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
		</ul>
            <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter tag">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;Search</button>
      </form>
      </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav><!--navigation menu closed-->
<div class="container" style="width: 100%; padding-left: 40px;"><!--container start-->
<div class="row">
  <?php
        include_once 'dbConnection.php';

        $email = $_SESSION['email'];

        $sql = "SELECT photo FROM user WHERE email='$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result);
          $photo = $row['photo'];
          //header("Content-type: image/png");
          //echo $photo;
          $base64Image = base64_encode($photo);
          $dataURI = "data:image/png;base64," . $base64Image;
          echo '<img src="' . $dataURI . '" class="img-responsive " alt="Student image" style="width: 9%; height: auto; margin-left:28px;">';
        } else {
          $photo = 'images/user.png';
        }
        include_once 'dbConnection.php';
echo '<span class="log1"><a class="stdt" href="account.php?q=1">'.$name.'</span></a>';
        ?>
        <hr class="liner"><br>
        <b class="regy">REG NO:&nbsp; 
    <?php
        include_once 'dbConnection.php';
        $email = $_SESSION['email'];
        $sql = "SELECT Reg_number
                FROM user
                where email = '$email'
                LIMIT 1";
        $result = mysqli_query($con, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result);
          $Reg_num = $row['Reg_number'];
          echo $Reg_num;
        } else {
          $Reg_num = 'not a valid student';
        }
        ?>
        </b>
        <hr class="liner">
        <span class="timen">EXAMINATION-TIME<br><a class="navbar-brand timens" href="#" id="countdown"></a></span>
        <br><a href="logout.php"><br><br><br><br><button type="button" class="subm" onclick="confirmSubmission()">SUBMIT NOW</button></a>
<div class="push">
<script>
  function confirmSubmission() {
    var confirmation = confirm("Are you sure you want to submit?");
    if (confirmation) {
      // If the user confirms, submit the form
      document.getElementById().submit();
    } else {
      event.preventDefault();
    }
}
</script>


<!--home start-->
<?php 
    if(@$_GET['q']==1) {
$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$title = $row['title'];
	$total = $row['total'];
	$Right = $row['Right'];
  $time = $row['time'];
	$eid = $row['eid'];
$q12=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error98');
$rowcount=mysqli_num_rows($q12);	
if($rowcount == 0){
	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$Right*$total.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="account.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:#99cc32"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
}
else 
{
echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.'&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>'.$total.'</td><td>'.$Right*$total.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Restart</b></span></a></b></td></tr>';
}
}
$c=0;
echo '</table></div></div>';

}?>

<!--quiz start-->
<?php
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
    $name = $_SESSION['name'];
    $email=$_SESSION['email'];
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];
    $qid = "";
    $x = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'");
    while ($row = mysqli_fetch_array($x)){
      $title = $row['title'];
    }

    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
    echo '<div class="panel">';
    while ($row = mysqli_fetch_array($q)) {
        $qns = $row['qns'];
        $qid = $row['qid'];
        $type = $row['question_type'];
        echo '<b>Question ' . $sn . '&nbsp;:<br />' . $qns . '</b><br /><br />';
    }

    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");
    echo '<form action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal"><br />';
  $questionNumber = $sn;

    $row = mysqli_fetch_array($q);

    if ($type == "objective") {
        // Display options for objective questions
        while ($row) {
            $option = $row['option'];
            $optionid = $row['optionid'];
            echo '<input type="radio" name="ans" data-question="' . $sn . '"value="' . $optionid . '">&nbsp;' . $option . '<br /><br />';
            $row = mysqli_fetch_array($q);
        }
    } elseif ($type == "subjective") {
        // Display a text area for subjective questions
        echo '<textarea name="ans" rows="6" class="form-control" placeholder="Enter your answer here" data-question="' . $questionNumber . '"></textarea><br />';
      }

    echo '<div><br /><div>';
    if ($sn > 1) {
        // Show "Previous" button only if there's a previous question
        echo '<a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn - 1) . '&t=' . ($total) . '" class="btn btn-success next-button">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Previous
            </a></div>';
    }

    if ($sn < $total) {
        // Show "Next" button for all questions except the last one
        echo '<button type="submit" id="next-button" class="btn btn-success prev-button"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>&nbsp;Next</button></form></div>';
    } else {
        // Redirect to the home page after the last question
        echo '</form></div>'; 
    }
    echo '<br><br>';
    echo '<br><br>';
    echo '<br><br>';
    for ($i = 1; $i<= $total; $i++){
      echo '<a href ="account.php?q=quiz&step=2&eid='. $eid . '&n=' . $i . '&t=' . $total. '"class="btn btn-default qstbt">'. $i . '</a>' ;
    }
}
?>
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    const questionButtons = document.querySelectorAll('.qstbt');

    radioButtons.forEach((radio) => {
        radio.addEventListener("click", function () {
            // Find the data-question attribute of the clicked radio button
            const questionNumber = radio.getAttribute("data-question");
            
            // Remove "answered" class from all question buttons
            questionButtons.forEach((btn) => {
                btn.classList.remove("answered");
            });

            // Find the corresponding question button using the data-question attribute
            const correspondingButton = document.querySelector(`[data-question="${questionNumber}"]`);
            
            if (correspondingButton) {
                // Add the "answered" class to the corresponding question button
                correspondingButton.classList.add("answered");
            }
        });
    });
});
</script> -->
<?php
//history start
if(@$_GET['q']== 2) 
{
$q=mysqli_query($con,"SELECT * FROM history WHERE email='$email' ORDER BY date DESC " )or die('Error197');
echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:red"><td><b>S.N.</b></td><td><b>Quiz</b></td><td><b>Question Solved</b></td><td><b>Right</b></td><td><b>Wrong<b></td><td><b>Score</b></td>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$eid=$row['eid'];
$s=$row['score'];
$w=$row['wrong'];
$r=$row['Right'];
$qa=$row['level'];
$q23=mysqli_query($con,"SELECT title FROM quiz WHERE  eid='$eid' " )or die('Error208');
while($row=mysqli_fetch_array($q23) )
{
$title=$row['title'];
}
$c++;
echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
}
echo'</table></div>';
}

//ranking start
if(@$_GET['q']== 3) 
{
$q=mysqli_query($con,"SELECT * FROM rank  ORDER BY score DESC " )or die('Error223');
echo  '<div class="panel title"><div class="table-responsive">
<table class="table table-striped title1" >
<tr style="color:red"><td><b>Rank</b></td><td><b>Name</b></td><td><b>Gender</b></td><td><b>College</b></td><td><b>Score</b></td></tr>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$e=$row['email'];
$s=$row['score'];
$q12=mysqli_query($con,"SELECT * FROM user WHERE email='$e' " )or die('Error231');
while($row=mysqli_fetch_array($q12) )
{
$name=$row['name'];
$gender=$row['gender'];
$college=$row['college'];
}
$c++;
echo '<tr><td style="color:#99cc32"><b>'.$c.'</b></td><td>'.$name.'</td><td>'.$gender.'</td><td>'.$college.'</td><td>'.$s.'</td><td>';
}
echo '</table></div></div>';}
ob_end_flush();
?>



</div></div></div></div>

<!--Modal for admin login-->
	 <div class="modal fade" id="login">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><span style="color:orange;font-family:'typo' ">LOGIN</span></h4>
      </div>
      <div class="modal-body title1">
<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">
<form role="form" method="post" action="admin.php?q=index.php">
<div class="form-group">
<input type="text" name="uname" maxlength="20"  placeholder="Admin user id" class="form-control"/> 
</div>
<div class="form-group">
<input type="password" name="password" maxlength="15" placeholder="Password" class="form-control"/>
</div>
<div class="form-group" align="center">
<input type="submit" name="login" value="Login" class="btn btn-primary" />
</div>
</form>
</div><div class="col-md-3"></div></div>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--footer end-->

<script>
    function startCountdown(duration, display) {
        var startTime = localStorage.getItem('startTime');
        if (!startTime) {
            startTime = Date.now();
            localStorage.setItem('startTime', startTime);
        }

        var timer = duration, minutes, seconds;
        var countdownTimer = setInterval(function () {
            var currentTime = Date.now();
            var elapsedTime = (currentTime - startTime) / 1000; // Elapsed time in seconds

            timer = duration - elapsedTime; // Calculate remaining time

            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (timer <= 0) {
                clearInterval(countdownTimer);
                localStorage.removeItem('startTime'); // Clear the stored start time when the countdown is completed
                
            }
            if (timer < 0){
              window.location.href="logout.php";
              return;
            }
        }, 1000);
    }

    window.onload = function () {
        var durationMinutes = 20;
        var countdownDisplay = document.getElementById('countdown');
        startCountdown(durationMinutes * 60, countdownDisplay);
    };
</script>
<!-- Add this JavaScript code within your HTML file -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    const textareas = document.querySelectorAll('textarea');
    const questionButtons = document.querySelectorAll('btn btn-default qstbt');

    radioButtons.forEach((radio) => {
        radio.addEventListener("change", function () {
            const questionNumber = radio.getAttribute("data-question");
            applyAnsweredStyle(questionNumber);
        });
    });

    textareas.forEach((textarea) => {
        textarea.addEventListener("input", function () {
            const questionNumber = textarea.getAttribute("data-question");
            applyAnsweredStyle(questionNumber);
        });
    });

    // Function to apply the "answered" style to a question button
    function applyAnsweredStyle(questionNumber) {
        const correspondingButton = document.querySelector(`[data-question="${questionNumber}"]`);
        if (correspondingButton) {
            correspondingButton.classList.add("answered");
        }
    }

    // Retrieve and set stored answers when the page loads
    function setStoredAnswers() {
        questionButtons.forEach((button) => {
            const questionNumber = button.getAttribute("data-question");
            if (hasAnswered(questionNumber)) {
                button.classList.add("answered");
            }
        });
    }

    // Function to check if a question has been answered
    function hasAnswered(questionNumber) {
        return sessionStorage.getItem('question_' + questionNumber) === 'answered';
    }

    setStoredAnswers();
});
</script>




</body>
</html>
