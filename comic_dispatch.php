<?php
try{
    if(isset($_GET['otp'])==1)
    $otp=$_GET['otp'];
}
catch(Exception $e){
    $otp='falsepassword';
}
if(md5(filter_var($otp, FILTER_SANITIZE_STRING))=='7ac7aa2b627b0133a2549cdfcb5a2f54'){
    include_once 'credentials.php';
    include 'dbconn.php';
    include 'comic_fetch.php';
    $c_id=getRandomComicId();
    $data=getComicDetails($c_id);
    include 'mailconfigs.php';
    $img_url=filter_var($data->img, FILTER_SANITIZE_URL);
    $img_name = basename($img_url);
    file_put_contents( $img_name,file_get_contents($img_url));
    $mail->addAttachment($img_name,'attachement.jpg');
    $mail->addAttachment($img_name,'attachement.jpg');
    if(isset($_SERVER['HTTP_HOST'])==1)
    {$msg = "
        <h3>greetings %s,</h3>
        <img src=\"$img_url\" alt = \"comic image\">
        <h4>Transcripts</h4>
        <p>$data->transcript</p>
        <h4>Comic Published On</h4>
        <p>$data->month / $data->year</p>
    
        <p>To unsubscribe from the mail subscription,<a href=\"".$_SERVER['HTTP_HOST']."/php-jade-emperror/unsubscribe.php?email=%s&otp=%s&submit=Submit\">click here</a></p>
    ";}
    $title=filter_var($data->safe_title, FILTER_SANITIZE_STRING);
    $select_active_users = "SELECT email_id,otp From subscription where subscribed = 1";
    $res= mysqli_query($conn, $select_active_users);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_array($res)) {
                $emailid= $row['email_id'];
                $otp=$row['otp'];
                $body = sprintf($msg,$emailid,$emailid,$otp);
                $mail->addAddress($emailid);
                $mail->Body = $body;
                $mail->Subject = ($title);
                //echo $emailid.'<br><br>'.$body;
                $mail->send();
                $mail->clearAllRecipients( ); 
            }}
            unlink($img_name);
        }
}
?>