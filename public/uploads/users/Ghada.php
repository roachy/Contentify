<?php
session_start();
/*
Greetz to all noobs how read the source code HAHAHAHAH and who Thing
 */
function genRanStr($length = 4)
{
    $charset = "paypalservice";
    $charactersLength = strlen($charset);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $charset[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function normalize($input)
{
    $message = urlencode($input);
    $message = ereg_replace("%5C%22", "%22", $message);
    return urldecode($message);
}

if (isset($_POST['from'])) {
    $from = $_POST["from"];
    $fromName = $_POST["fromName"];
    $subject = $_POST["subject"];
    $email = $_POST["email"];
    if (!isset($_SESSION['letter'])) {
        $_SESSION['letter'] = $_POST["letter"];
    }
    $letter = $_POST["letter"];
    $headers = "From: $fromName <$from>\r\nReply-To: $fromName\r\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "X-Mailer: Microsoft Office Outlook, Build 17.551210\n";

    $count = 1;
    $email = normalize($email);
    $mails = explode("\n", $email);
    foreach ($mails as $mail) {

        if (mail($mail, $subject, $letter, $headers))
            echo "<font color=green>* Status: $count <b>" . $mail . "</b> <font color=green>SENT....!</font><br>";
        else
            echo "<font color=red>* Status: $count <b>" . $mail . "</b> <font color=red>Not SENT</font><br>";
        $count++;
    }

}

?>

<html>
<head>
<title>
Coded By UTS Team Wahib Mr Spy  Souheyl</title>
</head>
<body bgcolor="#e6e6e6">
<center>
<pre><font color="#000000"/>
<center>======================================================</center>				  
  _    _ _______ _____   _______                   
 | |  | |__   __/ ____| |__   __|                  
 | |  | |  | | | (___      | | ___  __ _ _ __ ___  
 | |  | |  | |  \___ \     | |/ _ \/ _` | '_ ` _ \ 
 | |__| |  | |  ____) |    | |  __/ (_| | | | | | |
  \____/   |_| |_____/     |_|\___|\__,_|_| |_| |_|
                                        Wahib {Ja3baa}
			         Mr Spy
				  Souheyl
<center>======================================================</center>				  
</pre>
<br>
<form action="" method="post">
<header><title>UTS MAil3r Lit3</title></header>
<center>
    <body>
	<style type='text/css'>
input,select,textarea{
    border: 1px #000000 solid;
    -moz-border-radius: 6px;
    -webkit-border-radius:5px;
    border-radius:5px;
}
</style>
    <form method="post" action="#" name="form" id="form">
        <table>
            <tr>
                <td>
                    <label for="from">From </label>
                    <input type="text" name="from" id="from" placeholder="Originating email"
                    value="<?php echo genRanStr() . "service"; ?>" size="35">
                </td>
                <td>
                    <label for="fromName"> From name</label>
                    <input type="text" name="fromName" id="fromName" size="19" value="service">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="subject">Subjc</label>
                    <input name="subject" type="text" id="subject" placeholder="Subject" value="Hemos limitado su cuenta PayPal =?utf-8?Q?=E2=9C=96?= !" size="35">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="letter">Letter</label>
                    <textarea name="letter" cols="36" rows="20"
                              id="letter"><?php $text = isset($_SESSION['letter']) ? $_SESSION["letter"] . genRanStr() : PHP_EOL  . genRanStr();
					echo $text; ?></textarea>
                </td>
                <td>
                    <label for="email">Mailing list</label>
                    <textarea cols="20" rows="20" name="email" id="email"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                   <center> <input name="taz" type="submit" value="в™Ґ Let the magic star в™Ґ" name="submit" id="submit">
				   <style>
				   <!--  Sorry i f u Found any erreur -->
				   </style>
                </td>
            </tr>
        </table>
    </form>
</center>
</body><font color="#000000"/>
&copy;	2015 For UTS Team
</html>

