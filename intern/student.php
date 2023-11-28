<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>CBT: Start Exam</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

 
  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
<!--alert message-->
<?php if(@$_GET['w'])
{echo'<script>alert("'.@$_GET['w'].'");</script>';}
?>
</head>
<?php
include_once 'dbConnection.php';
?>
<body>
<div class="header">
<div class="row">
<div class="col-lg-6">
<span class="logo">PLEASE READ CARFULLY</span></div>
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

include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hi,</span> <a href="account.php?q=1" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Leave</button></a></span>';
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
      <a class="navbar-brand" href="#"><b></b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		</ul>
      </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav><!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">

<!--home start-->

<div class="panel">
  <div class="container">
    <div class="row">
      <div class="col-md-4"><br>
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
          echo '<img src="' . $dataURI . '" class="img-responsive" alt="Student image" style="width: 60%; height: auto;">';
        } else {
          $photo = 'images/user.png';
        }
        ?>
      </div>
      <div class="col-md-8">
        <h3>Name: <b><?php
        include_once 'dbConnection.php';
        $email = $_SESSION['email'];
        $sql = "SELECT name
                FROM user
                where email = '$email'";
        $result = mysqli_query($con, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result);
          $name = $row['name'];
          echo $name;
        } else {
          $name = 'not a valid student';
        }
        ?></h3>
        <br>
        <h4><b>Registration Number: <b><?php
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
        ?></b></h4><br>
        <p>Please read the following instructions before starting the exam:</p>
        <p>1. The exam will be open for 1 hour.</p>
        <p>2. You must answer all questions in order to pass the exam.</p>
        <p>3. There is no partial credit for the exam.</p>
        <br>
        <a href="account.php?q=1" type="button" class="btn btn-primary"><span class="fas fa-arrow-right" aria-hidden="true"></span> &nbsp; Select Exam</a>      </div>
    </div>
  </div>
</div>
</div></div></div></div>
<!--Footer start-->
<div class="row footer">
<div class="col-md-3 box">
</div>
<!--footer end-->
</body>
</html>
