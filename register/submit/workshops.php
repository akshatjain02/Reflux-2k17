<?php

include "../../embeds/settings.php";

if(!in_array("workshops", $closed))
{
	$name = trim(strip_tags($_POST["name"]));
	$designation = trim(strip_tags($_POST["designation"]));
	$email = trim(strip_tags($_POST["email"]));
	$phone = trim(strip_tags($_POST["phone"]));
	$institute = trim(strip_tags($_POST["institute"]));
	$workshopsList = trim(strip_tags($_POST["workshopsList"]));
	$workshopsList = explode('##',$workshopsList);
	$uid = md5(time());
	$eol = PHP_EOL;

	$email_to = "submission.reflux@gmail.com";
	$email_from = "submissions@reflux.in";
	$email_reply = "nitish@reflux.in";
	$email_subject = "Workshops - $name";
	$email_msg = "Name: $name\nInstitute: $institute\nDesignation: $designation\n\nEmail: $email\nPhone: $phone\n\nWorkshops interested in:\n";
	for($i=0;$i<count($workshopsList);$i++)
	{
		$workshopName = $workshopsList[$i];
		$email_msg .= "$workshopName\n";
	}

	$email_headers  = "From: $email_from".$eol;
	$email_headers .= "Reply-To: $email_reply".$eol;
	$email_headers .= "MIME-Version: 1.0".$eol;
	$email_headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"".$eol;

	$email_body  = "--".$uid."\r\n";
	$email_body .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
	$email_body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$email_body .= $email_msg.$eol;
	$email_body .= "--".$uid."--\r\n";

	// echo $email_headers."\n";
	// echo $email_body."\n";

	$mail_sent = @mail($email_to,$email_subject,$email_body,$email_headers);
	echo $mail_sent ? "Your entry has been submitted" : "Sorry! We are unable to submit your entry at the present.";
}

?>