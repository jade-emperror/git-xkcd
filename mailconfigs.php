<?php
include_once 'credentials.php';
use PHPMailer\PHPMailer\PHPMailer;
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host=$smtp_host;
$mail->SMTPAuth=true;
$mail->Username= $from_mail_id;
$mail->Password=$from_mail_pwd;
$mail->Port=$smtp_port;
$mail->SMTPSecure = 'ssl';
$mail->isHTML(true);
$mail->setFrom($from_mail_id);

$mail->SMTPDebug = 0;
?>