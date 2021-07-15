<h1>Problem Statement - <a href="https://learn.rtcamp.com/campus/php-assignments/">Email a random XKCD challenge</a></h1>
<h3><a href="http://3.142.103.221/git-xkcd/">Live demo - XKCD COMIC SUBSCRIPTION</a></h3>
<h3>Tech Stacks</h3>
<ol>
<li>FRONT END - HTML,CSS,JS</li>
<li>Back END - PHP </li>
<li>DB - MySQL</li>
<li>Hosting - AWS EC2 instance</li>
</ol>
<h3> Working</h3>
The working of the project is divided into two sub parts
<ol>
<li>Registration,Emaiing service</li>
<li>Fetching Data From XKCD Comic URL</li>
</ol>
<h4>1.Registration,Emaiing service</h4>
<p>The Email address of the subscriber is sent with an confirmation link with hidden hashed OTP,on clicking of the confirm button,the subscriber is authenticated.the emailing service in the application is google's SMTP protocol used with PHPMailer to send email.</p>
<h4>2.Fetching Data From XKCD Comic URL</h4>
<p>for fetching data from <a href="https://c.xkcd.com/random/comic/">XKCD</a> the unique comic id is required,which is acquired from <a href="https://c.xkcd.com/random/comic/">this url</a>.the acquired comic id is then used to get required data(as JSON) from the api portal of xkcd by appending the portal(<a href="https://xkcd.com/614/info.0.json"><b>https://xkcd.com/[Unique_Comic_ID]/info.0.json</b></a>) with unique id.now the attained data is formatted into required pattern and sent as mail using a PHP script.<br>
for recursive emailing(every 5mins),<br>
the mailing script discussed earlier is added as a cronjob in the linux machine(AWS EC2 instance)
</p>

<h3> Screenshots from the Project</h3>
<img src="readme_res/index.png" alt="index">
<img src="readme_res/authentication.png" alt="authentication">
<img src="readme_res/thankyou.png" alt="thankyou">
<img src="readme_res/mail.png" alt="mail">
<img src="readme_res/unsub.png" alt="unsubscribe">
