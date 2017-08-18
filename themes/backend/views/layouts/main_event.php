<!DOCTYPE html>
<html class=" ">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/bootstrap.min.js" type="text/javascript"></script> 
        <title><?php echo '(' . Yii::app()->user->getUser("username") . ') ' . $this->pageTitle ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description"  content="Administrator :: Badan Pembinaan Organisasi, Kaderisasi dan Keanggotaan (BPOKK) Partai Demokrat" />
		<meta name="keywords" content="" />
        <meta name="author"  content="BITSolution" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/apple-touch-icon-144-precomposed.png">
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body onload="" style="background-image: url(http://foto.fajar.co.id/wp-content/uploads/2017/02/sby-demokrat-1024x683.jpg);background-size: cover;">
		<?php echo $content; ?>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/autosize.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.easing.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/pace.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/viewportchecker.js" type="text/javascript"></script>		
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/scripts.js" type="text/javascript"></script>  
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/perfect-scrollbar.min.js" type="text/javascript"></script>
    </body>
</html>