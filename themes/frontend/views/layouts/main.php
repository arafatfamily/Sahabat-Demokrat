<!DOCTYPE html>
<!--[if lte IE 8]><html class="ie8 no-js" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en-US"><![endif]-->
<!--[if !(IE)]><!--><html class="not-ie no-js" lang="en-US"><!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery-1.11.3.min.js"></script>
	<title>KTA Sahabat Demokrat</title>
	<meta name="description" content="Kartu Tanda Anggota Partai Demokrat yang dikeluarkan oleh Badan Pembinaan Organisasi, Kaderisasi dan Keanggotaan (BPOKK) Dewan Pimpinan Pusat Partai Demokrat">
	<meta name="keywords" content="sahabat, demokrat, sahabat demokrat, kta, anggota, partai, partai demokrat, sby, bpokk, kader">
	<meta name="author" content="mediainsularo">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:700,500,400%7cCourgette%7cRoboto:400,500,700%7CIndie+Flower:regular%7COswald:300,regular,700&amp;subset=latin%2Clatin-ext'
		  rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/normalize.css"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/styles.css"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/customized.css"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/layout.css"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/vendor.css"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/fontello.css"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/layerslider.css"/>
	<style>
	.croppedImg {
		width:inherit;
		height:inherit;
	}
	.cropContainerModal img {
		width:inherit;
		height:inherit;
	}
	select, input {
		font-size: 1rem !important;
		padding: 0.5rem 1.125rem !important;
	}
	label {
		color: #0063ff !important;
		padding-left: 10px;
	}
	</style>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.modernizr.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/plugins.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/modals.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/config.js"></script>
</head>
<body class="animated">
<!--?php require_once('loader.php') ?-->
<div id="wrapper" style="background: url(<?php echo Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "bg_situs")); ?>) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
	<nav id="mobile-advanced" class="mobile-advanced"></nav>
	<header id="header" class="header type-3">
	<?php require_once('headerTop.php') ?>
	<?php require_once('headerMid.php') ?>
	<?php require_once('headerMenu.php') ?>
	</header>
	<?php echo $content; ?>		
	<?php require_once('siteModal.php') ?>
	<footer id="footer">
	<?php require_once('footerTop.php') ?>
		<div class="footer-bottom">
			<div class="row">
				<div class="large-6 columns">
					<div class="copyright">
						Copyright &copy;<?php echo date('Y') ?>. BPOKK Partai Demokrat. All rights reserved
					</div>
				</div>
				<div class="large-3 large-offset-3 columns">
					<div class="developed">
						Developer Team <a target="_blank" href="http://mediainsularo.com"><b>Media Insularo</b></a>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
<!--[if lt IE 9]>
<script src="js/vendor/respond.min.js"></script>
<script src="js/vendor/jquery.selectivizr.min.js"></script>
<![endif]-->

<!--<script src="js/vendor/mediaelement/mediaelement-and-player.min.js"></script>-->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/twitterFetcher_min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/greensock.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/layerslider.transitions.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/owl.carousel.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/theme.js"></script> 
</body>
</html>