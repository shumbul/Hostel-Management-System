<?php
session_start();
if (isset($_POST['signup-submit'])) {

  require 'config.inc.php';

  $roll = $_POST['student_roll_no'];
  $fname = $_POST['student_fname'];
  $lname = $_POST['student_lname'];
  $mobile = $_POST['mobile_no'];
  $dept = $_POST['department'];
  $year = $_POST['year_of_study'];
  $password = $_POST['pwd'];
  $cnfpassword = $_POST['confirmpwd'];


  if(!preg_match("/^[a-zA-Z0-9]*$/",$roll)){
    echo"<script>alert('error=invalidroll');window.location='../signup.php'</script>";
    //header("Location: ../signup.php?error=invalidroll");
    exit();
  }
  else if($password !== $cnfpassword){
    echo"<script>alert('error=passwordcheck');window.location='../signup.php'</script>";
    //header("Location: ../signup.php?error=passwordcheck");
    exit();
  }
  else {

    $sql = "SELECT Student_id FROM Student WHERE Student_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo"<script>alert('error=sqlerror');window.location='../signup.php'</script>";
      //header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $roll);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        echo"<script>alert('error=userexists');window.location='../signup.php'</script>";
        //header("Location: ../signup.php?error=userexists");
        exit();
      }
      else {
        $sql = "INSERT INTO Student (Student_id, Fname, Lname, Mob_no, Dept, Year_of_study, Pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          echo"<script>alert('error=sqlerror');window.location='../signup.php'</script>";
          //header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {

          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          mysqli_stmt_bind_param($stmt, "sssssss",$roll, $fname, $lname, $mobile, $dept, $year, $hashedPwd);
          mysqli_stmt_execute($stmt);
          echo"<script>alert('signup=success');window.location='../index.php'</script>";
          //header("Location: ../index.php?signup=success");
          exit();
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  echo"<script>alert(' ');window.location='../signup.php'</script>";
  //header("Location: ../signup.php");
  exit();
}
