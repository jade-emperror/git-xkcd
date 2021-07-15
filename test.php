<?php
$msg = "

</head>
<body>

    <span class=\"main-msg\">click the below button to subscribe</span>
    <br>
    <span class=\"sub-msg\">if the msg is received mistakenly kindly ignore it,you will not be registered without clicking the link below.</span>
    <a class=\"sub-btn\" href=\"%s/php-jade-emperror/validate.php?email=%s&otp=1234&submit=Confirm\">Confirm</a>

</body>
</html>
";
$otp = md5(1234);
$email="maestrobharath@gmail.com";
echo sprintf($msg,"localhost",$email);
?>