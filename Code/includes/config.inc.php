<?php
  session_start();
//  $servername = "localhost"; //change this  accordingly
//  $dBUsername = "root";
//  $dBPassword = "dbmsproject";
//  $dBName = "hostel_management_system";
 // session_start();
 $conn=mysqli_connect("localhost","root","dbmsproject","hostel_management_system");

  if (!$conn) {
    die("Connection Failed: ".mysqli_connect_error());
  }
?>
