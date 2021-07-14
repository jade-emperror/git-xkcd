<?php
if(isset($_GET['submit']))
{
    if(isset($_GET['email'])==1)
    $email=$_GET['email'];
    if(isset($_GET['otp'])==1)
    $otp=$_GET['otp'];
    include('credentials.php');
    include('dbconn.php');
    if (mysqli_connect_errno()) {
        //take somewhere
        exit();
      }
    
    $querey = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($querey, "UPDATE subscription set subscribed = 1 WHERE email_id = ? and otp = ? and subscribed = 0");
    mysqli_stmt_bind_param($querey, "ss", $email ,$otp);
    mysqli_stmt_execute($querey);
    mysqli_commit($conn);
    mysqli_close($conn);
    header("Location: subscribed.html");
} 
?>