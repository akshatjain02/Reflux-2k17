<?php

include "../../embeds/settings.php";

if(!in_array("ideation", $closed))
{
	$teamsize = trim(strip_tags($_POST["teamsize"]));
	$members = trim(strip_tags($_POST["members"]));
	$institute = trim(strip_tags($_POST["institute"]));
	$uid = md5(time());
	$eol = PHP_EOL;

	$memberArr = explode('##',$members);

	$tempfile_doc = $_FILES['doc'];
	$filename_doc = $_FILES['doc']['name'];
	$filesize_doc = $_FILES['doc']['size'];
	$filetype_doc = $_FILES['doc']['type'];
	$tempname_doc = $_FILES['doc']['tmp_name'];
	$tempfile_image = $_FILES['image'];
	$filename_image = $_FILES['image']['name'];
	$filesize_image = $_FILES['image']['size'];
	$filetype_image = $_FILES['image']['type'];
	$tempname_image = $_FILES['image']['tmp_name'];

	$fp = fopen($tempname_doc, "rb");
	$doc = fread($fp, $filesize_doc);
	fclose($fp);
	$doc = chunk_split(base64_encode($doc));

	$fp = fopen($tempname_image, "rb");
	$image = fread($fp, $filesize_image);
	fclose($fp);
	$image = chunk_split(base64_encode($image));

	$email_to = "submission.reflux@gmail.com";
	$email_from = "submissions@reflux.in";
	$email_reply = "nitish@reflux.in";
	$email_subject = "Ideation challenge";
	$email_msg = "Institute: $institute\nTeam size: $teamsize\n";
	for($i=0;$i<$teamsize;$i++)
	{
		$details = explode('#',$memberArr[$i]);
		$email_msg .= "\nMember ".($i+1).":"."\n  Name: ".$details[0]."\n  Designation: ".$details[1]."\n  Email: ".$details[2]."\n  Phone: ".$details[3];
	}

	$email_headers  = "From: $email_from".$eol;
	$email_headers .= "Reply-To: $email_reply".$eol;
	$email_headers .= "MIME-Version: 1.0".$eol;
	$email_headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"".$eol;

	$email_body  = "--".$uid."\r\n";
	$email_body .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
	$email_body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$email_body .= $email_msg.$eol;
	$email_body .= "--".$uid."\r\n";
	$email_body .= "Content-Type: ".$filetype_doc."; name=\"".$filename_doc."\"".$eol;
	$email_body .= "Content-Transfer-Encoding: base64".$eol;
	$email_body .= "Content-Disposition: attachment; filename=\"".$filename_doc."\"".$eol;
	$email_body .= $doc;
	$email_body .= "--".$uid."\r\n";
	$email_body .= "Content-Type: ".$filetype_image."; name=\"".$filename_image."\"".$eol;
	$email_body .= "Content-Transfer-Encoding: base64".$eol;
	$email_body .= "Content-Disposition: attachment; filename=\"".$filename_image."\"".$eol;
	$email_body .= $image;
	$email_body .= "--".$uid."--\r\n";

	// echo $email_headers."\n";
	// echo $email_body."\n";

	$mail_sent = @mail($email_to,$email_subject,$email_body,$email_headers);
	echo $mail_sent ? "Your entry has been submitted" : "Sorry! We are unable to submit your entry at the present.";
}

?>