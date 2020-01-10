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

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="<?=base_url("assets/")?>vendor/summernote/summernote.css" />
        <link rel="stylesheet" href="<?=base_url("assets/")?>vendor/summernote/summernote-bs4.css" />
        <link rel="stylesheet" href="<?= base_url('assets/')?>vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
		<link rel="stylesheet" href="<?= base_url('assets/')?>vendor/pnotify/pnotify.custom.css" />
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
        <section class="body">
            <!-- start: header -->
            <header class="header">
                <div class="logo-container">
					<a href="../" class="logo">
						<img src="<?= base_url()?>assets/images/logo.png" height="35" alt="Ares" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>

                <!-- start: user box -->
                <div class="header-right">

                    <span class="separator"></span>

                    <div id="userbox" class="userbox">
                        <a href="#" data-toggle="dropdown">
                            <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                                <span class="name"><?= $_SESSION["userName"] ?></span>
                                <span class="role"><?= $_SESSION["userPosition"] ?></span>
                            </div>

                            <i class="fa custom-caret"></i>
                        </a>

                        <div class="dropdown-menu">
                            <ul class="list-unstyled">
                                <li class="divider"></li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="<?= base_url("user/edit_user/").$_SESSION["userId"]?>"><i class="fa fa-user"></i> My Profile</a>
                                </li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="<?= base_url("login/logout")?>"><i class="fa fa-power-off"></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end: user box -->
            </header>
            <!-- end: header -->

            <div class="inner-wrapper">
                <!-- start: sidebar -->
                <aside id="sidebar-left" class="sidebar-left">
                
                    <div class="sidebar-header">
                        <div class="sidebar-title">
                            Navigation
                        </div>
                        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                        </div>
                    </div>
                
                    <div class="nano">
                        <div class="nano-content">
                            <nav id="menu" class="nav-main" role="navigation">
                                <ul class="nav nav-main">
                                    <li>
                                        <a href="<?= base_url("dashboard")?>">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-child" aria-hidden="true"></i>
                                            <span>Bot</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('bot/train_bot')?>">
                                                    Train Bot
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('bot/check_message')?>">
                                                    Check Bot
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                                            <span>Intent</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('intent/all_intent')?>">
                                                    All Intent
                                                </a>
                                                <a href="<?= base_url('intent/new_intent')?>">
                                                    New Intent
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                            <span>Entity</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('entity/all_entity')?>">
                                                    All Entity
                                                </a>
                                                <a href="<?= base_url('entity/new_entity')?>">
                                                    New Entity
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-database" aria-hidden="true"></i>
                                            <span>Sample</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('sample/all_sample')?>">
                                                    All Sample
                                                </a>
                                                <a href="<?= base_url('sample/new_sample')?>">
                                                    New Sample
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-gavel" aria-hidden="true"></i>
                                            <span>Condition</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('condition/all_condition')?>">
                                                    All Condition
                                                </a>
                                                <a href="<?= base_url('condition/new_condition')?>">
                                                    New Condition
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                            <span>Response</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('response/all_response')?>">
                                                    All Response
                                                </a>
                                                <a href="<?= base_url('response/new_response')?>">
                                                    New Response
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-chain" aria-hidden="true"></i>
                                            <span>Condition-Response</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('conresponse/all_condition_response')?>">
                                                    All Condition-Response
                                                </a>
                                                <a href="<?= base_url('conresponse/new_condition_response')?>">
                                                    New Condition-Response
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <?php if($_SESSION["userPosition"] == "admin"){?>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <span>Message</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('message/all_message')?>">
                                                    View All
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <?php if($_SESSION["userPosition"] == "admin"){?>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                            <span>Users</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('user/all_user')?>">
                                                    View All
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('user/new_user')?>">
                                                    New User
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-file" aria-hidden="true"></i>
                                            <span>Item</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('item/all_item')?>">
                                                    All Item
                                                </a>
                                                <a href="<?= base_url('item/new_item')?>">
                                                    New Item
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-desktop" aria-hidden="true"></i>
                                            <span>App</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= base_url('app/all_app')?>">
                                                    All App
                                                </a>
                                                <a href="<?= base_url('app/new_app')?>">
                                                    New App
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                
                    </div>
                
                </aside>
                <!-- end: sidebar -->

                <section role="main" class="content-body">
                    <header class="page-header">
                        <h2><?= $title?></h2>
                    
                        <div class="right-wrapper pull-right">
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="index.html">
                                        <i class="fa fa-home"></i>
                                    </a>
                                </li>
                                <li><span><?= $subtitle?></span></li>
                                <li><span><?= $title?></span></li>
                            </ol>
                    
                            <span class="sidebar-right-toggle"></span>
                        </div>
                    </header>
