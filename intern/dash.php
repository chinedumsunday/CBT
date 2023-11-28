<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>CBT</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

<script>
$(function () {
    $(document).on( 'scroll', function(){
        console.log('scroll top : ' + $(window).scrollTop());
        if($(window).scrollTop()>=$(".logo").height())
        {
             $(".navbar").addClass("navbar-fixed-top");
        }

        if($(window).scrollTop()<$(".logo").height())
        {
             $(".navbar").removeClass("navbar-fixed-top");
        }
    });
});</script>
</head>

<body  style="background:#eee;">
<div class="header">
<div class="row">
<div class="col-lg-6">
<span class="logo">Computer Based Test</span></div>
<?php
 include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
  if(!(isset($_SESSION['email']))){
header("location:index.php");

}
else
{
$name = $_SESSION['name'];;

include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="account.php" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>

</div></div>
<!-- admin start-->

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
      <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard</b></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dash.php?q=1">User</a></li>
		<li <?php if(@$_GET['q']==3) echo'class="active"'; ?>><a href="dash.php?q=3">Feedback</a></li>
        <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active"'; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quiz<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dash.php?q=4">Add Quiz</a></li>
            <li><a href="dash.php?q=5">Remove Quiz</a></li>
            <li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="dash.php?q=2">Report</a></li>
			
          </ul>
        </li><li class="pull-right"> <a href="logout.php?q=account.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Signout</a></li>
		
      </ul>
          </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">
<!--home start-->

<?php if(@$_GET['q']==0) {

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

}
?>
<?php
if (@$_GET['q'] == 2) {
  echo '
  <!-- Step 1: Buttons and Selection -->
  <form method="post" action="">
      <label>Select Student:</label>
      <select name="student">
      <option value="" selected disabled>Select Student</option>'; // Default option
          
          // Fetch student names from the user table
          $studentQuery = "SELECT name FROM user";
          $studentResult = mysqli_query($con, $studentQuery);
          while ($studentRow = mysqli_fetch_assoc($studentResult)) {
              $studentName = $studentRow['name'];
              echo '<option value="' . $studentName . '">' . $studentName . '</option>';
          }

  echo '</select>
      
      <label>Select Exam:</label>
      <select name="exam">
      <option value="" selected disabled>Select Exam</option>';
      
          // Fetch exam titles from the quiz table
          $examQuery = "SELECT title FROM quiz";
          $examResult = mysqli_query($con, $examQuery);
          while ($examRow = mysqli_fetch_assoc($examResult)) {
              $examTitle = $examRow['title'];
              echo '<option value="' . $examTitle . '">' . $examTitle . '</option>';
          }

  echo '</select>
      
      <button class="btn btn-primary" type="submit" name="generate_report">Generate Report</button>
  </form>';
  
  // Step 2: Generate Report
  if (isset($_POST['generate_report'])) {
    $selectedStudent = isset($_POST['student']) ? $_POST['student'] : "";
    $selectedExam = isset($_POST['exam']) ? $_POST['exam'] : "";
    
    // Construct the WHERE clause based on the selected entries
    $whereClause = "";
    if (!empty($selectedStudent) && !empty($selectedExam)) {
        $whereClause = "name='$selectedStudent' AND exam_title='$selectedExam'";
    } elseif (!empty($selectedStudent)) {
        $whereClause = "name='$selectedStudent'";
    } elseif (!empty($selectedExam)) {
        $whereClause = "exam_title='$selectedExam'";
    }
    
    // Use SQL queries with the constructed WHERE clause
    $query = "SELECT * FROM history";
    if (!empty($whereClause)) {
        $query .= " WHERE $whereClause";
    }
    $result = mysqli_query($con, $query);
      
      // Step 3: Display Report
      echo '<div class="panel title"><div class="table-responsive">
      <table class="table table-striped title1" >
      <tr><td><b>Student</b></td><td><b>Exam</b></td><td><b>Score</b></td></tr>';
      
      while ($row = mysqli_fetch_assoc($result)) {
          $studentName = $row["name"];
          $examName = $row["exam_title"];
          $score = $row["score"];
          
          echo "<tr><td>" . $studentName . "</td><td>" . $examName . "</td><td>" . $score . "</td></tr>";
      }
      
      echo "</table></div></div>";
  }
  
  // Step 4: Print Button
  echo '<button class="btn btn-primary" onclick="printReport()">Print Report</button>
  <script>
      function printReport() {
          var tableToPrint = document.querySelector(".table-responsive table");
          var printWindow = window.open("", "_blank");
  
          printWindow.document.write("<html><head><title>Print Report</title></head><body>");
          printWindow.document.write(tableToPrint.outerHTML);
          printWindow.document.write("</body></html>");
  
          printWindow.document.close();
          printWindow.print();
          printWindow.close();
      }
  </script>';
}
?>




<!--home closed-->
<!--users start-->
<?php if(@$_GET['q']==1) {

$result = mysqli_query($con,"SELECT * FROM user") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Name</b></td><td><b>Gender</b></td><td><b>Reg_Number</b></td><td><b>Email</b></td><td><b>Mobile</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$name = $row['name'];
	$mob = $row['mob'];
	$gender = $row['gender'];
    $email = $row['email'];
	$Reg_Number = $row['Reg_Number'];

	echo '<tr><td>'.$c++.'</td><td>'.$name.'</td><td>'.$gender.'</td><td>'.$Reg_Number.'</td><td>'.$email.'</td><td>'.$mob.'</td>
	<td><a title="Delete User" href="update.php?demail='.$email.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
}
$c=0;
echo '</table></div></div>';

}?>
<!--user end-->

<!--feedback start-->
<?php if(@$_GET['q']==3) {
$result = mysqli_query($con,"SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Subject</b></td><td><b>Email</b></td><td><b>Date</b></td><td><b>Time</b></td><td><b>By</b></td><td></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$date = $row['date'];
	$date= date("d-m-Y",strtotime($date));
	$time = $row['time'];
	$subject = $row['subject'];
	$name = $row['name'];
	$email = $row['email'];
	$id = $row['id'];
	 echo '<tr><td>'.$c++.'</td>';
	echo '<td><a title="Click to open feedback" href="dash.php?q=3&fid='.$id.'">'.$subject.'</a></td><td>'.$email.'</td><td>'.$date.'</td><td>'.$time.'</td><td>'.$name.'</td>
	<td><a title="Open Feedback" href="dash.php?q=3&fid='.$id.'"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
	echo '<td><a title="Delete Feedback" href="update.php?fdid='.$id.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td>

	</tr>';
}
echo '</table></div></div>';
}
?>
<!--feedback closed-->

<!--feedback reading portion start-->
<?php if(@$_GET['fid']) {
echo '<br />';
$id=@$_GET['fid'];
$result = mysqli_query($con,"SELECT * FROM feedback WHERE id='$id' ") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$name = $row['name'];
	$subject = $row['subject'];
	$date = $row['date'];
	$date= date("d-m-Y",strtotime($date));
	$time = $row['time'];
	$feedback = $row['feedback'];
	
echo '<div class="panel"<a title="Back to Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Ubuntu", sans-serif;"><b>'.$subject.'</b></h1>';
 echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;'.$date.'</span>
<span style="line-height:35px;padding:5px;">&nbsp;<b>Time:</b>&nbsp;'.$time.'</span><span style="line-height:35px;padding:5px;">&nbsp;<b>By:</b>&nbsp;'.$name.'</span><br />'.$feedback.'</div></div>';}
}?>
<!--Feedback reading portion closed-->

<!--add quiz start-->
<?php
if(@$_GET['q']==4 && !(@$_GET['step']) ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   <form class="form-horizontal title1" name="form" action="update.php?q=addquiz"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name"></label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="total"></label>  
  <div class="col-md-12">
  <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="right"></label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="wrong"></label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="tag"></label>  
  <div class="col-md-12">
  <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="desc"></label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
  </div>
</div>


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form>

</div>';



}
?>
<!--add quiz end-->

<!--add quiz step2 start-->
<?php
$eid = isset($_GET['eid']) ? $_GET['eid'] : "";
if(isset($_GET['q']) && $_GET['q'] == 4 && isset($_GET['step']) && $_GET['step'] == 2) {
  echo '<div class="row">
  <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
  <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&typ='.@$_GET['qns'.$i.'Select'].'&ch=4 "  method="POST">
  <fieldset>';
  
  for($i = 1; $i <= $_GET['n']; $i++) {
    echo '<b>Question number&nbsp;'.$i.'&nbsp;:</b><br />
    <div class="form-group">
      <label class="col-md-12 control-label" for="qns'.$i.'"></label>  
      <div class="col-md-12">
        <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control" placeholder="Write question number '.$i.' here..."></textarea>
      </div>
    </div>
    
    <div class="form-group">
  <label class="col-md-12 control-label" for="type'.$i.'Select"></label>
  <div class="col-md-12">
    <select id="qns'.$i.'Select" class="form-control" name="qns'.$i.'Select">
      <option value="objective">Objective</option>
      <option value="subjective">Subjective</option>
    </select>
  </div>
</div>
<div id="options'.$i.'"></div>

    <script>
      const qnsSelect'.$i.' = document.getElementById("qns'.$i.'Select");
      const optionsDiv'.$i.' = document.getElementById("options'.$i.'");

      qnsSelect'.$i.'.addEventListener("change", function() {
        optionsDiv'.$i.'.innerHTML = ""; // Clear existing content
        const selectedOption = this.value;

        if (selectedOption === "objective") {
          optionsDiv'.$i.'.innerHTML = \'<label for="optionsA'.$i.'">Option A:</label><input type="text" class="form-control" id="optionsA'.$i.'" name="optionsA'.$i.'"><br>\' +
                                \'<label for="optionsB'.$i.'">Option B:</label><input type="text" class="form-control" id="optionsB'.$i.'" name="optionsB'.$i.'"><br>\' +
                                \'<label for="optionsC'.$i.'">Option C:</label><input type="text" class="form-control" id="optionsC'.$i.'" name="optionsC'.$i.'"><br>\' +
                                \'<label for="optionsD'.$i.'">Option D:</label><input type="text" class="form-control" id="optionsD'.$i.'" name="optionsD'.$i.'"><br>\' +
                                \'<label for="correctOption'.$i.'">Correct Option:</label><select class="form-control" id="correctOption'.$i.'" name="correctOption'.$i.'">'.
                                  '<option value="optionA">Option A</option>'.
                                  '<option value="optionB">Option B</option>'.
                                  '<option value="optionC">Option C</option>'.
                                  '<option value="optionD">Option D</option>'.
                                '</select><br>\';
        } else if (selectedOption === "subjective") {
          optionsDiv'.$i.'.innerHTML = \'<label for="subjectiveCorrect'.$i.'">Correct Answer (comma-separated):</label><input type="text" class="form-control" id="subjectiveCorrect'.$i.'" name="subjectiveCorrect'.$i.'"><br>\';
        }
        </script>';
  }

  echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>
</fieldset></form>
</div>
<form id="csvForm" action="swiss.php" method="post" enctype="multipart/form-data">
    <label for="csv_file">Upload Questions via CSV File:</label>
    <input type="file" class = "btn btn-primary" name="csv_file" accept=".csv"><br>
    <input type="submit" class ="btn btn-primary" value="Import Questions">
    <input type="hidden" name="eid" value='.$eid.'>
    <br>
    <br>
    <a href = "csv_temp.php" class="btn btn-primary" >Download CSV file template</a>
</form>


<div id="result"></div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#csvForm").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        
        var formData = new FormData(this);

            $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $("#result").html(response);
            },
            error: function() {
                $("#result").html("An error occurred.");
            }
        });
    });
});
</script>
</div>';
}?>
<!--add quiz step 2 end-->

<!--remove quiz-->
<?php if(@$_GET['q']==5) {

$result = mysqli_query($con,"SELECT * FROM quiz") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$title = $row['title'];
	$total = $row['total'];
	$Right = $row['Right'];
    $time = $row['time'];
	$eid = $row['eid'];
	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$Right*$total.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="update.php?q=rmquiz&eid='.$eid.'" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Remove</b></span></a></b></td></tr>';
}
$c=0;
echo '</table></div></div>';

}
?>
</div><!--container closed-->
</div></div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const uploadButton = document.querySelector("[type='button']");

    uploadButton.addEventListener("click", function(e) {
        const fileInput = document.querySelector("[type='file']");
        const uploadedFile = fileInput.files[0];

        if (!uploadedFile || uploadedFile.type !== "text/csv") {
            e.preventDefault();
            alert("Please select a valid CSV file.");
            return;
        }

        const requiredColumns = ["question_text", "option_a", "option_b", "option_c", "option_d", "correct_option"];

        const reader = new FileReader();
        reader.onload = function(event) {
            const content = event.target.result;
            const lines = content.split("\n");
            const header = lines[0].split(",");
            
            for (const column of requiredColumns) {
                if (!header.includes(column)) {
                    e.preventDefault();
                    alert(`The CSV file must include the "${column}" column.`);
                    return;
                }
            }
        };

        reader.readAsText(uploadedFile);
    });
});
</script>
</body>
</html>
