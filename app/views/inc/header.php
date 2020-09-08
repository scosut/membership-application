<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= SITE_NAME; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Barlow+Condensed:300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" integrity="sha256-46qynGAkLSFpVbEBog43gvNhfrOj+BmwXdxFgVK/Kvc=" crossorigin="anonymous" />
	<link rel="icon" type="image/png" href="/public/img/favicon.png">
	<link rel="stylesheet" href="/public/css/style.css">
</head>
<body<?= Utility::isActive('/applications') ? " class=\"dashboard-body\"" : ""; ?>>
	<header id="header"<?= Utility::isActive('/') ? "class=\"fadeIn\"" : " class=\"secondary\""; ?>>
		<?php require_once "nav.php"; ?>
		
		<?php if(Utility::isActive('/')): ?>
		<div id="why" class="fadeInLeft">
			<h3>Why join the Business Club?</h3>
			<ul>
				<li><i class="fas fa-check"></i><span>leadership opportunities</span></li>
				<li><i class="fas fa-check"></i><span>guest speakers</span></li>
				<li><i class="fas fa-check"></i><span>field trips</span></li>
				<li><i class="fas fa-check"></i><span>virtual stock exchange game</span></li>
				<li><i class="fas fa-check"></i><span>tax preparation training</span></li>
				<li><i class="fas fa-check"></i><span>networking with faculty, students, and community members</span></li>
			</ul>
			<a href="/applications/add" class="btn">Apply Now</a>
		</div>
		<?php endif; ?>
	</header>