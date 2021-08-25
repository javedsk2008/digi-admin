<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">  
<style type="text/css">
@media screen {
   @font-face{
       font-family:'Open Sans';
       font-style:normal;
       font-weight:400;
       src:local('Open Sans'), local('OpenSans'), url('http://fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
   }
}
</style>  
 <!--[if mso]>
<style type=”text/css”>
.fallback-text {
font-family: Arial, sans-serif;
}
</style>
<![endif]-->
 <!--[if !mso]><!-- -->    
 <style type="text/css">
    * {
  margin: 0;
  padding: 0;
  font-size: 100%;
  font-family: 'Raleway', sans-serif;
   }

img {
  max-width: 100%;
  margin: 0 auto;
  display: block; }

body,
.body-wrap {
 /* width: 100% !important;
  height: 100%;
  background-color: #fff;
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none; */
  font-family: 'Raleway', sans-serif;
  width: 100% !important;
  height: 100%;
   background-color: #fff;
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none;
  max-width: 615px;
  margin: 0px auto;}
  .borderFourSite{
    border-top: 3px solid #2d9938;
    border-right: 4px solid #065ba4;
    border-bottom: 3px solid #065ba4;
    border-left: 4px solid #2d9938;
  }
a {
  color: #0b377a;
  text-decoration: none; }

.text-center {
  text-align: center; }

.text-right {
  text-align: right; }

.text-left {
  text-align: left; }

.button {
  display: inline-block;
  color: white;
  background: #71bc37;
  border: solid #71bc37;
  border-width: 10px 20px 8px;
  font-weight: bold;
  border-radius: 0px;  
  margin:10px 10px 10px 0;
}
.green-button {
  display: inline-block;
  color: #222;
  background:#47b451;
  border: solid #47b451;
  border-width: 6px 0px;
  font-weight: bold; 
  width: 100%;
  margin:10px 0;
}
.blue-button:hover, .green-button:hover {color:#fff !important;}

h1, h2, h3, h4, h5, h6 {
  margin-bottom: 10px;
  line-height: 1.25; }

h1 {
  font-size: 32px; }

h2 {
  font-size: 24px;color:#065ba4; }

h3 {
  font-size: 24px; }

h4 {
  font-size: 20px; }

h5 {
  font-size: 16px; }

p, ul, ol {
  font-weight: normal;   
  }
p{line-height:1.65;}
.container {
  display: block !important;
  clear: both !important;
  margin: 0 auto !important;
  max-width: 580px !important; }
  .container table {
    width: 100% !important;
    border-collapse: collapse;
    margin: 5px auto;
    overflow:hidden;}
  .container .masthead { 
    color: white; 
  padding: 20px 35px;}
    .container .masthead h1 {
      margin: 15px auto !important;
      max-width: 90%;
      text-transform: uppercase; }
  .container .content {
    background: white;
    padding: 0px 35px; }
    .container .content.footer {
      background: none; 
    }
      .container .content.footer p {
        margin-bottom: 0;
        color: #888;
        text-align: center;
        font-size: 12px; }
      .container .content.footer a {
        color: #888;
    font-weight:normal !important;
        text-decoration: none;
font-weight: bold; }
.color-boder-blue{background-color:#3565AE;margin:0px 0 10px 0;overflow:hidden;}
.color-border-green{background:url("https://www.emsys.solutions/keeping/bottom-line.png") no-repeat;width:118px;height:13px;margin: 0 2px;}
.messageline1{font-size:12px;font-family: 'Raleway', sans-serif;padding:0 20px;}
.head-text{font-size:12px;font-family: 'Raleway', sans-serif;font-weight:800;font-size:20px;color:#065ba4;border-top:2px solid #ABAEAB;border-bottom:2px solid #ABAEAB;text-transform:uppercase; text-align:center;line-height: 1.65;}
    </style>
</head>
<body>
<table class="body-wrap borderFourSite">
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td align="center" class="masthead">

                        <h1><img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png"></h1>
            <div class="head-text">Resend OTP</div>
                    </td>
                </tr>
                <tr>
                    <td class="content">
                        <h2><em>Dear {{ $user['full_name'] }},</em></h2>
                        <p>A request to send OTP was received from your DigiTeacher account for the email id - {{ $user['email'] }}<br /></p>
                        <table>
                            <tr>
                                <td align="left">
                                    <p>
                                        <a href="" target="_blank" class="green-button text-center">{{$user['password_reset_token']}}</a>
                                    </p>

                                </td>
                            </tr>
                        </table>
            <p><b>Note :</b> This OTP is valid for 1 hour from the time it was sent to you and can be used to change your password only once.</p><br />
            <p><b>IMP :</b> <span class="customer-line1">if you have not initiated this request,</span> 
            <a href="#" style="text-decoration: underline;">report it to us immediately</a></p><br />
            <p class="text-right">Thank you<br />Global Grahak Team</p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <!-- <td class="container">   
            <table style="margin-bottom: 20px;">
                <tr>
                    <td class="content footer">
                        <div class="color-boder-blue"><div class="color-border-green"></div></div>
                        <p style="text-align:left;padding:0 20px;">This message was send to <a href="mailto:patilsandeep13@gmail.com">patilsandeep13@gmail.com</a> if you dont want to receive these emails from buildwizz in the future.please <a href="#" style="text-decoration:underline;">unsubscribe</a>.</p>
                    </td>
                </tr>       
            </table>

        </td> -->
    </tr>
</table>
</body>
</html>