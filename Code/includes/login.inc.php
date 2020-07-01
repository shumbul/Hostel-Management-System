<?php
session_start();
if (isset($_POST['login-submit'])) {

  require 'config.inc.php';

  $roll = $_POST['student_roll_no'];
  $password = $_POST['pwd'];

  if (empty($roll) || empty($password)) {
    echo"<script>alert('error=emptyfields');window.location='../index.php'</script>";
    //header("Location: ../index.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT *FROM Student WHERE Student_id = '$roll'";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
      $pwdCheck = password_verify($password, $row['Pwd']);
      if($pwdCheck == false){
        echo"<script>alert('error=wrongpwd');window.location='../index.php'</script>";
        //header("Location: ../index.php?error=wrongpwd");
        exit();
      }
      else if($pwdCheck == true) {

        //session_start();
        $_SESSION['roll'] = $row['Student_id'];
        $_SESSION['fname'] = $row['Fname'];
        $_SESSION['lname'] = $row['Lname'];
        $_SESSION['mob_no'] = $row['Mob_no'];
        $_SESSION['department'] = $row['Dept'];
        $_SESSION['year_of_study'] = $row['Year_of_study'];
        $_SESSION['hostel_id'] = $row['Hostel_id'];
        $_SESSION['room_id'] = $row['Room_id'];
        if(isset($_SESSION['department'])){
          echo "<script type='text/javascript'>alert('Set')</script>";
        }
        else {
          echo "<script type='text/javascript'>alert('Not SET')</script>";
        }
        //echo $_SESSION['lname'];
      //  header("Location: ../home.php?login=success");
        echo"<script>alert('login sucess');window.location='../home.php'</script>";
        //exit();
      }
      else {
        echo"<script>alert('error=stranger');window.location='../index.php'</script>";
    //    header("Location: ../index.php?error=strangeerr");
        exit();
      }
    }
    else{
      echo"<script>alert('error=nouser');window.location='../index.php'</script>";
  //    header("Location: ../index.php?error=nouser");
      exit();
    }
  }

}
else {
  echo"<script>alert('');window.location='../index.php'</script>";

  exit();
}
