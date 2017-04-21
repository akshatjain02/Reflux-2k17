<?php

include "../../embeds/settings.php";

if(!in_array("quiz_enigma", $closed))
{
	$teamsize = trim(strip_tags($_POST["teamsize"]));
	$members = trim(strip_tags($_POST["members"]));
	$institute = trim(strip_tags($_POST["institute"]));
	$teamname = trim(strip_tags($_POST["teamname"]));
	$uid = md5(time());
	$eol = PHP_EOL;

	$memberArr = explode('##',$members);

	// echo "$teamsize\n";
	// print_r($memberArr);
	// echo "$institute\n";
	// echo "$teamname\n";

	$email_to = "submission.reflux@gmail.com";
	$email_from = "submissions@reflux.in";
	$email_reply = "nitish@reflux.in";
	$email_subject = "Enigma quiz - $teamname";
	$email_msg = "Institute: $institute\nTeamname: $teamname\nTeam size: $teamsize\n";
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
	$email_body .= "--".$uid."--\r\n";

	// echo $email_headers."\n";
	// echo $email_body."\n";

	$mail_sent = @mail($email_to,$email_subject,$email_body,$email_headers);
	echo $mail_sent ? "Your registration was successful!" : "Sorry! We are unable to register you at the present.";
}

?>