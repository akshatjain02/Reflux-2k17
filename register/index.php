<?php
	$relative_path = "../";
	$current_page = "Participate";
	$navbar_style = "navbar-static-top";
	$forms = array("exhibition","workshops","case_study","green_tech","quiz_enigma","ideation","industrial_design","paper_presentation","photography","poster_presentation","process_design");
?>

<!DOCTYPE html>

<head>
	<title>Register | Reflux '16</title>
	<?php include "$relative_path"."embeds/include.php"; ?>
	<link rel="stylesheet" href="../css/register.css" type="text/css" />
</head>

<body>

	<?php include '../embeds/navbar.php'; ?>

	<div class="container page-content">

		<h2 class="text-center title">Participate in Reflux 2016<span class="hidden-xs hidden-sm"> : Climate Unchange : For a better tomorrow</span></h2>
		<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-10 col-md-offset-2 col-sm-offset-1" id="formBox">
			<div class="container-fluid">
			<?php if( (!isset($_GET['section'])) || (empty($_GET['section']) ) || ($_GET['section']=="menu") ) { ?>
				<?php include "menu.html"; ?>
			<?php } else if(in_array($_GET['section'], $closed)) { ?>
				<div class="section" id="wrong">
					<h3 class="text-center section-title">Entries for this competition are now closed!</h3>
					<h4 class="text-center">Do come back in the next edition of Reflux</h4>
					<h3 class="text-center section-title"><a href="?section=menu" class="dotted customLink">Click here to go back to the menu</a></h3>
				</div>
			<?php } else if(in_array($_GET['section'], $forms)) { ?>
				<?php include "form/".$_GET['section'].".html"; ?>
			<?php } else if($_GET['section']=="success") { ?>
				<?php include "success.php"; ?>
			<?php } else { ?>
				<div class="section" id="wrong">
					<h3 class="text-center section-title">This page does not exists!</h3>
					<h3 class="text-center section-title"><a href="?section=menu" class="dotted customLink">Click here to go back to the menu</a></h3>
				</div>
			<?php } ?>
			</div>
			</div>
		</div>
		</div>
	</div>
	
	<script type="text/javascript" src="../js/register.js"></script>
		
</body>