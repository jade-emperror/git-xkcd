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
    $ext = explode('.',$img_name)[1];
    if($ext=='jpg'||$ext == 'jpe')
    $ext='jpeg';

    $file = $img_name;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $name = basename($file);
    $eol = PHP_EOL;
    $content = chunk_split(base64_encode($content)); 
    
    if(isset($_SERVER['HTTP_HOST'])==1)
    {$msg = "
        <h3>greetings %s,</h3>
        <img src=\"$img_url\" alt = \"comic image\">
        <h4>Transcripts</h4>
        <p>$data->transcript</p>
        <h4>Comic Published On</h4>
        <p>$data->month / $data->year</p>
    
        <p>To unsubscribe from the mail subscription,<a href=\"".$_SERVER['HTTP_HOST']."/git-xkcd/unsubscribe.php?email=%s&otp=%s&submit=Submit\">click here</a></p>
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
                $subject = "XKCD COMIC - ".$title;

                //attaching headers
                $uid = md5(uniqid(time()));
                $headers = "From: $fromName"." <".$from.">"."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"";
                $message = "--".$uid.$eol;
                $message .= "Content-Type: text/html; charset=ISO-8859-1".$eol;
                $message .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
                $message .= $body.$eol;
                $message .= "--".$uid.$eol;
                $message .= "Content-Type: image/".$ext."; name=\"".$img_name."\"".$eol;
                $message .= "Content-Transfer-Encoding: base64".$eol;
                $message .= "Content-Disposition: attachment; filename=\"".$img_name."\"".$eol;
                $message .= $content.$eol;
                $message .= "--".$uid."--";

                if (mail($emailid, $subject, $message, $headers))
                {
                    echo "mail_success";
                }
                else
                {
                    echo "mail_error";
                } 
            }}
            unlink($img_name);
        }
}
?>
