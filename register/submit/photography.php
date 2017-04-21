<?php

include "../../embeds/settings.php";

if(!in_array("photography", $closed))
{
	$name = trim(strip_tags($_POST["name"]));
	$designation = trim(strip_tags($_POST["designation"]));
	$email = trim(strip_tags($_POST["email"]));
	$phone = trim(strip_tags($_POST["phone"]));
	$institute = trim(strip_tags($_POST["institute"]));
	$caption = trim(strip_tags($_POST["caption"]));
	$description = trim(strip_tags($_POST["description"]));
	$fb = trim(strip_tags($_POST["fb"]));
	$uid = md5(time());
	$eol = PHP_EOL;

	$tempfile = $_FILES['file'];
	$filename = $_FILES['file']['name'];
	$filesize = $_FILES['file']['size'];
	$filetype = $_FILES['file']['type'];
	$tempname = $_FILES['file']['tmp_name'];

	$fp = fopen($tempname, "rb");
	$file = fread($fp, $filesize);
	fclose($fp);
	$file = chunk_split(base64_encode($file));

	$email_to = "submission.reflux@gmail.com";
	$email_from = "submissions@reflux.in";
	$email_reply = "nitish@reflux.in";
	$email_subject = "Photography competition - $name";
	$email_msg = "Name: $name\nInstitute: $institute\nDesignation: $designation\n\nEmail: $email\nPhone: $phone\nFB link: $fb\n\nCaption: $caption\nDescription: $description\n";

	$email_headers  = "From: $email_from".$eol;
	$email_headers .= "Reply-To: $email_reply".$eol;
	$email_headers .= "MIME-Version: 1.0".$eol;
	$email_headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"".$eol;

	$email_body  = "--".$uid."\r\n";
	$email_body .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
	$email_body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$email_body .= $email_msg.$eol;
	$email_body .= "--".$uid."\r\n";
	$email_body .= "Content-Type: ".$filetype."; name=\"".$filename."\"".$eol;
	$email_body .= "Content-Transfer-Encoding: base64".$eol;
	$email_body .= "Content-Disposition: attachment; filename=\"".$filename."\"".$eol;
	$email_body .= $file;
	$email_body .= "--".$uid."--\r\n";

	// echo $email_headers."\n";
	// echo $email_body."\n";

	$mail_sent = @mail($email_to,$email_subject,$email_body,$email_headers);
	echo $mail_sent ? "Your entry has been submitted" : "Sorry! We are unable to submit your entry at the present.";
}

?>