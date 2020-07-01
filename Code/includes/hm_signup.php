<?php
session_start();
if (isset($_POST['hm_signup_submit'])) {

  require 'config.inc.php';

  $username= $_POST['hm_uname'];
  $fname = $_POST['hm_fname'];
  $lname = $_POST['hm_lname'];
  $mobile = $_POST['hm_mobile'];
  $hostel_name = $_POST['hostel_name'];
  $password = $_POST['pass'];
  $cnfpassword = $_POST['confpass'];


  if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
    echo"<script>alert('error=invalidusername');window.location='../admin/create_hm.php'</script>";
    //header("Location: ../admin/create_hm.php?error=invalidusername");
    exit();
  }
  else if($password !== $cnfpassword){
    echo"<script>alert('error=passwordcheck');window.location='../admin/create_hm.php'</script>";
    //header("Location: ../admin/create_hm.php?error=passwordcheck");
    exit();
  }
  else {

    $sql = "SELECT Username FROM Hostel_Manager WHERE Username=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo"<script>alert('error=sqlerror');window.location='../admin/create_hm.php'</script>";
      //header("Location: ../admin/create_hm.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        echo"<script>alert('error=userexists');window.location='../admin/create_hm.php'</script>";
        //header("Location: ../admin/create_hm.php?error=userexists");
        exit();
      }
      else {
      //  $sql = "INSERT INTO Hostel_Manager (Student_id, Fname, Lname, Mob_no, Dept, Year_of_study, Pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
        //$sql = "INSERT INTO Hostel_Manager (Username, Fname, Lname, Mob_no, Hostel_id, Email, Pwd, Isadmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        //$stmt = mysqli_stmt_init($conn);

          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          $sql = "SELECT *FROM Hostel WHERE Hostel_name = '$hostel_name'";
          $result = mysqli_query($conn, $sql);
          if($row = mysqli_fetch_assoc($result)){
            $HostelID = $row[Hostel_id];
            $zz = 0;
            $sql = "INSERT INTO Hostel_Manager (Username, Fname, Lname, Mob_no, Hostel_id, Mess_id, Pwd, Isadmin) VALUES ('$username', '$fname', '$lname', '$mobile', '$HostelID', '$HostelID', '$hashedPwd', '$zz')";
          //  mysqli_stmt_bind_param($stmt, "ssssssss",'$username', $fname, $lname, $mobile, $HostelID, $email, $hashedPwd, $zz);
          //  mysqli_stmt_execute($stmt);
          $result = mysqli_query($conn, $sql);
          if($result){
            echo"<script>alert('added=success');window.location='../admin/create_hm.php'</script>";
            //header("Location: ../admin/create_hm.php?added=success");
          }
          else {
            echo"<script>alert('added=failure');window.location='../admin/create_hm.php'</script>";
            //header("Location: ../admin/create_hm.php?added=failure");
          }

          //  exit();
          }
          else {
            echo"<script>alert('error=nohostel');window.location='../admin/create_hm.php'</script>";
            //header("Location: ../admin/create_hm.php?error=nohostel");
            exit();
          }


      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  echo"<script>alert(' ');window.location='../admin/create_hm.php'</script>";
  //header("Location: ../admin/create_hm.php");
  exit();
}
