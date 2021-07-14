<?php
include_once('credentials.php');
include('dbconn.php');
include('comic_fetch.php');
$c_id=getRandomComicId();
$data=getComicDetails($c_id);
include('mailconfigs.php');
$img_url=$data->img;
$img_name = basename($img_url);
file_put_contents( $img_name,file_get_contents($img_url));
$mail->addAttachment($img_name,'attachement.jpg');
$msg = "
    <h3>greetings %s,</h3>
    <img src=\"$img_url\" alt = \"comic image\">
    <h4>Transcripts</h4>
    <p>$data->transcript</p>
    <h4>Comic Published On</h4>
    <p>$data->month / $data->year</p>

    <p>To unsubscribe from the mail subscription,<a href=\"3.142.103.221/git-xkcd/unsubscribe.php?email=%s&submit=Submit\">click here</a></p>
";
$title=$data->safe_title;
$select_active_users = "SELECT email_id From subscription where subscribed = 1";

if ($res = mysqli_query($conn, $select_active_users)) {
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_array($res)) {
            $emailid= $row['email_id'];
            $body = sprintf($msg,$emailid,$emailid);
            $mail->addAddress($emailid);
            $mail->Body = $body;
            $mail->Subject = ($title);
            //echo $emailid.'<br><br>'.$body;
            $mail->send();
            $mail->clearAllRecipients( ); 
        }}
    }
unlink($img_name);
?>