<?php
session_start();


if (isset($_POST['hm_remove_submit'])) {

  require 'config.inc.php';

  $username = $_POST['hm_uname'];
  $hostel_name = $_POST['hostel_name'];
  $Adminpassword = $_POST['pass'];

  if (empty($username) || empty($hostel_name) || empty($Adminpassword)) {
    echo"<script>alert('error=emptyfields');window.location='../admin/create_hm.php'</script>";
    //header("Location: ../admin/create_hm.php?error=emptyfields");
    exit();
  }
    else {
      $sql = "SELECT *FROM Hostel_Manager WHERE Username = '$username'";
      $result = mysqli_query($conn, $sql);
      if($row = mysqli_fetch_assoc($result)){

      $sql2 = "SELECT *FROM Hostel WHERE Hostel_name = '$hostel_name'";
      $result2 = mysqli_query($conn, $sql2);
      if($row2 = mysqli_fetch_assoc($result2)){
        $HNO = $row2['Hostel_id'];
        if ($HNO == $row['Hostel_id']) {

          if($Adminpassword=='123')
          $pwdCheck = true;
          else{
            $pwdCheck=false;
          }

          if ($pwdCheck==false) {
              echo"<script>alert('error=wrongpwd');window.location='../admin/create_hm.php'</script>";
          //  header("Location: ../admin/create_hm.php?error=wrongpwd");
            exit();
          }
          else {
            $sql3 = "DELETE FROM Hostel_Manager WHERE Username = '$username'";
            $result3 = mysqli_query($conn, $sql3);
            if($result3){
                echo"<script>alert('DeletionSuccessful');window.location='../admin/create_hm.php'</script>";
              //header("Location: ../admin/create_hm.php?DeletionSuccessful");
              exit();
            }
            else {
              echo"<script>alert('error=DeletionFailed');window.location='../admin/create_hm.php'</script>";
              //header("Location: ../admin/create_hm.php?error=DeletionFailed");
              exit();
            }
          }
        }
        else {
          echo"<script>alert('error=wronghostel');window.location='../admin/create_hm.php'</script>";
          //header("Location: ../admin/create_hm.php?error=wronghostel");
          exit();
        }
      }
      else {
        echo"<script>alert('error=nohostel');window.location='../admin/create_hm.php'</script>";
        //header("Location: ../admin/create_hm.php?error=nohostel");
        exit();
      }

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
        echo"<script>alert('login=success');window.location='../home.php'</script>";
        //header("Location: ../home.php?login=success");
        //exit();
      }
      else {
        echo"<script>alert('error=strangeerr');window.location='../index.php'</script>";
        //header("Location: ../index.php?error=strangeerr");
        exit();
      }
    }
    else{
      echo"<script>alert('error=nouser');window.location='../admin/create_hm.php'</script>";
      //header("Location: ../admin/create_hm.php?error=nouser");
      exit();
    }
  }

}
else {
  echo"<script>alert(' ');window.location='../index.php'</script>";
  //header("Location: ../index.php");
  exit();
}
