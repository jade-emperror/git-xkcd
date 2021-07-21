<?php
if(isset($_GET['submit']))
{
  include 'credentials.php';
  include 'dbconn.php';
    if(isset($_GET['email'])==1)
    $email=$_GET['email'];
    if(isset($_GET['otp'])==1)
    $otp=$_GET['otp'];
    if (mysqli_connect_errno()) {
        //take somewhere
        exit();
      }
    
    $query = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($query, 'UPDATE subscription set subscribed = 1 WHERE email_id = ? and otp = ? and subscribed = 0');
    mysqli_stmt_bind_param($query, 'ss', $email ,$otp);
    mysqli_stmt_execute($query);
    mysqli_commit($conn);
    mysqli_close($conn);
    header('Location: subscribed.html');
    exit();
} 
?>