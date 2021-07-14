<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- font styles-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=PT+Sans:ital,wght@0,700;1,400&display=swap" rel="stylesheet">   
    
    <!--CSS-->
    <link rel="stylesheet" href="css/index.css">
    <title>XKCD Subscription</title>
</head>
<body>
    <section class="top-section">
        <div class="xkcd-logo"><span class="logo">XKCD</span></div>
    </section>
    <section class="form-section">
        <div class="xkcd-desc-cont">
            <p class="xkcd-desc">Your regular dose of comic</p>
            <p class=xkcd-mini-desc>Register here for our regular mail subscription</p>
        </div>
        <div class="form-reg-cont">
            <form action="index.php" name="form1" method="post">
                <div class="form-content">
                    <input type="text" name="emailid" placeholder="email address" id="email" autocomplete="off" onkeydown="validateEmail(document.form1.emailid)">
                <input type="submit" name="submit" value="Register" id="submit-btn" >
                </div>
            </form>
            <span  id="error_msg">Enter a valid email address !</span>
        </div>
    </section>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['emailid'])==1)
    $email=$_POST['emailid'];
    // Removing the illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    include('dbconn.php');
    if (mysqli_connect_errno()) {
        //take somewhere
        exit();
      }
    $otp = md5(rand(1000,9999));
    $sub = 0;
    //inserting data into DB
    $querey = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($querey, "INSERT INTO subscription  VALUES (?,?,?)");
    mysqli_stmt_bind_param($querey, "sss", $email,$otp,$sub);
    include('mailconfigs.php');
    $flag=FALSE;
    $flag=mysqli_stmt_execute($querey);
  
if($flag){
    $mail->addAddress($email);
        $mail->Body = "
        <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link href=\"https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=PT+Sans:ital,wght@0,700;1,400&display=swap\" rel=\"stylesheet\">   
    
        <title>Document</title>
        <style>
            body{
                width:100vw;
                height: 100vh;
                display: flex;
                flex-direction:column;
                align-items:center;
                align-content:center;
                justify-content:start;
                font-family: 'PT Sans', sans-serif;
            }
            
            .main-msg{
              margin-top:5vh;
                font-size:5vh;
                margin-top:5%;
                text-transform: capitalize;
                color:black;
            }
            .sub-msg{
                font-size:2.3vh;
                margin-top:1%;
                text-transform: capitalize;
                color:black;
            }
            .sub-btn{
                background-color:skyblue;
                border: none;
                width:fit-content;
                height:fit-content;
                padding:1.5vh 2vw;
                border-radius: 5px;
            }
            .sub-btn:hover{
                cursor: pointer;
                transform:scale(1.2);
                transition: .1s;
            }
        </style>
    </head>
    <body>
        
            <span class=\"main-msg\">click the below button to subscribe</span>
            <br>
            <span class=\"sub-msg\">if the msg is received mistakenly kindly ignore it,you will not be registered without clicking the link below.</span>
            <form action=\"3.142.103.221//git-xkcd/validate.php\" method=\"get\">
                <input type=\"hidden\"  name=\"email\" value=\"$email\">
                <input type=\"hidden\"  name=\"otp\" value=\"$otp\">
                <input class=\"sub-btn\" type=\"submit\" name=\"submit\" value=\"Confirm\">
            </form>
      
        </body>
        </html>
        ";
        $mail->Subject = ("Verification for XKCD subscription");
    if($mail->send()){
        echo "<script>
        alert(\"check your mail for verification\");
        </script>";
    }
    else
    {
        echo "<script>
        alert(\"Server Error\");
        </script>";
    }
}
    //emailing authentication to subscribet
    
    else{
        echo "<script>
        alert(\"check your inbox mail is already sent\");
        </script>";

    }

    
    //header("Location: validate.php");
    exit();
} 
?>
</body>
<script>
    
    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{1,}))$/;
        
        if(re.test(email.value.toLowerCase()))
        {
            document.getElementById("error_msg").style.visibility="hidden";
            var btn = document.getElementById("submit-btn");
            btn.style.backgroundColor="#E50914";
            btn.disabled=false;
            }
        else
        {
        document.getElementById("error_msg").style.visibility="visible";
        var btn = document.getElementById("submit-btn");
        btn.style.backgroundColor="#404040";
        btn.disabled=true;
        }
        }
</script>


</html>