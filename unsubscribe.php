<?php
if(isset($_GET['submit']))
{
    if(isset($_GET['email'])==1)
    $email=$_GET['email'];
    include('credentials.php');
    include('dbconn.php');
    if (mysqli_connect_errno()) {
        //take somewhere
        exit();
      }
    
    $querey = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($querey, "delete from subscription where email_id = ?");
    mysqli_stmt_bind_param($querey, "s", $email);
    mysqli_stmt_execute($querey);
    mysqli_commit($conn);
    mysqli_close($conn);
    header("Location: unsubscribed.html");
} 
?>