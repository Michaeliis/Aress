<!doctype html>
<html class="fixed <?php if(isset($collapse)){echo 'sidebar-left-collapsed';}?>">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title><?= $title?></title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?=base_url("assets/")?>vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?=base_url("assets/")?>vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?=base_url("assets/")?>vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?=base_url("assets/")?>vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="<?= base_url('assets/')?>vendor/pnotify/pnotify.custom.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="<?=base_url("assets/")?>vendor/summernote/summernote.css" />
        <link rel="stylesheet" href="<?=base_url("assets/")?>vendor/summernote/summernote-bs4.css" />
        <link rel="stylesheet" href="<?= base_url('assets/')?>vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />

        <link rel="stylesheet" href="<?= base_url("assets/")?>vendor/select2/select2.css" />
		<link rel="stylesheet" href="<?= base_url("assets/")?>vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?=base_url("assets/")?>stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?=base_url("assets/")?>stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?=base_url("assets/")?>stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="<?=base_url("assets/")?>vendor/modernizr/modernizr.js"></script>

	</head>
	<body>