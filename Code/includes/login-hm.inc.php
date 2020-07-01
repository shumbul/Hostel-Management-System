<?php
session_start();
if (isset($_POST['login-submit'])) {

  require 'config.inc.php';

  $username = $_POST['username'];
  $password = $_POST['pwd'];

  if (empty($username) || empty($password)) {
    echo"<script>alert('error=emptyfields');window.location='../login-hostel_manager.php'</script>";
    //header("Location: ../login-hostel_manager.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT * FROM Hostel_Manager WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
      $pwdCheck =true;//password_verify($password, $row['Pwd']);
      //echo $pwdCheck ;
      if($pwdCheck == false){

        echo"<script>alert('error=wrongpwd');window.location='../login-hostel_manager.php'</script>";
        //header("Location: ../login-hostel_manager.php?error=wrongpwd");
        exit();
      }
      else if($pwdCheck == true) {

        //session_start();
        $_SESSION['hostel_man_id'] = $row['Hostel_man_id'];
        $_SESSION['fname'] = $row['Fname'];
        $_SESSION['lname'] = $row['Lname'];
        $_SESSION['mob_no'] = $row['Mob_no'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['hostel_id'] = $row['Hostel_id'];
        $_SESSION['isadmin'] = $row['Isadmin'];
        $_SESSION['PSWD'] = $row['Pwd'];

        //Just for checking if session variables are working properly
        if(isset($_SESSION['username'])){
          echo "<script type='text/javascript'>alert('Set')</script>";
        }
        else {
          echo "<script type='text/javascript'>alert('Not SET')</script>";
        }
        //echo $_SESSION['lname'];
        if($_SESSION['isadmin']==0){
          echo"<script>alert('login=success');window.location='../home_manager.php'</script>";
          //header("Location: ../home_manager.php?login=success");
        }
        else {
          echo"<script>alert('login=success');window.location='../admin/admin_home.php'</script>";
          //header("Location: ../admin/admin_home.php?login=success");
        }
        //exit();
      }
      else {
        echo"<script>alert('error=stranger');window.location='../login-hostel_manager.php'</script>";
        //header("Location: ../login-hostel_manager.php?error=strangeerr");
        exit();
      }
    }
    else{
      echo"<script>alert('error=nouser');window.location='../login-hostel_manager.php'</script>";
      //header("Location: ../login-hostel_manager.php?error=nouser");
      exit();
    }
  }

}
else {
  echo"<script>window.location='../login-hostel_manager.php'</script>";
  //header("Location: ../login-hostel_manager.php");
  exit();
}
