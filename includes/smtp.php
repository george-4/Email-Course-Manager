<?php

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require_once dirname(__FILE__) . '/config.inc.php';
require_once dirname(__FILE__) . '/PHPMailer/PHPMailerAutoload.php';


//Create a new PHPMailer instance
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = SMTP_DEBUG;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
$mail->Host = EMAIL_HOST;
$mail->Port = SMTP_PORT;
$mail->SMTPAuth = true;
$mail->Username = EMAIL_FROM;
$mail->Password = EMAIL_PASSWORD;
$mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
$mail->addReplyTo(EMAIL_REPLY, EMAIL_REPLY_NAME);
//$mail->isHTML(false); 


