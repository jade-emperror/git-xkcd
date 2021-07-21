<?php
if(isset($_GET['submit']))
{
    if(isset($_GET['email'])==1){
    $email=$_GET['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);}
    if(isset($_GET['otp'])==1){
    $otp=$_GET['otp'];
    $otp = filter_var($otp, FILTER_SANITIZE_STRING);}
    include 'credentials.php';
    include 'dbconn.php';
    if (mysqli_connect_errno()) {
        //take somewhere
        exit();
      }
    
    $query = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($query, 'delete from subscription where email_id = ? and otp = ?');
    mysqli_stmt_bind_param($query, 'ss', $email,$otp);
    mysqli_stmt_execute($query);
    mysqli_commit($conn);
    mysqli_close($conn);
    header('Location: unsubscribed.html');
    exit();
} 
?>