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
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/select2.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>
    <body class="">
        <div class='page-topbar '>
            <div class='logo-area'></div>
            <div class='quick-area'>
			<?php require_once('topLeft.php') ?>
			<?php require_once('topRight.php') ?>
            </div>
        </div>
        <div class="page-container row-fluid">
            <div class="page-sidebar ">
                <div class="page-sidebar-wrapper" id="main-menu-wrapper">
				<?php require_once('userProfile.php') ?>
				<?php require_once('userMenu.php') ?>
                </div>
                <div class="project-info">
                    <div class="block1">
                        <div class="data">
                            <span class='title'>Total Kader</span>
                            <span class='total'><?php echo Globals::Total('Member','',''); ?></span>
                        </div>
                        <div class="graph">
                            <span class="sidebar_orders">...</span>
                        </div>
                    </div>
                    <div class="block2">
                        <div class="data">
                            <span class='title'>Kader Online</span>
                            <span class='total'><?php echo Globals::Total('Member','member_status','A'); ?></span>
                        </div>
                        <div class="graph">
                            <span class="sidebar_visitors">...</span>
                        </div>
                    </div>
                </div>
            </div>
            <section id="main-content" class=" ">
			<?php require_once('userMain.php') ?>
            </section>
            <div class="page-chatapi hideit">
                <div class="search-bar">
                    <input type="text" placeholder="Search" class="form-control" disabled>
                </div>
                <div class="chat-wrapper">
                    <!--h4 class="group-head">Data Grup</h4>
                    <ul class="group-list list-unstyled">
                        <li class="group-row">
                            <div class="group-status available">
                                <i class="fa fa-circle"></i>
                            </div>
                            <div class="group-info">
                                <h4><a href="#">Admin Pusat</a></h4>
                            </div>
                        </li>
                        <li class="group-row">
                            <div class="group-status offline">
                                <i class="fa fa-circle"></i>
                            </div>
                            <div class="group-info">
                                <h4><a href="#">Admin Daerah</a></h4>
                            </div>
                        </li>
                        <li class="group-row">
                            <div class="group-status offline">
                                <i class="fa fa-circle"></i>
                            </div>
                            <div class="group-info">
                                <h4><a href="#">Admin Cabang</a></h4>
                            </div>
                        </li>
                    </ul-->
                    <h4 class="group-head">Daftar Administrator Sahabat</h4>
                    <ul class="contact-list">
					<!-- konten Chat -->
                    </ul>
                </div>
            </div>
            <div class="chatapi-windows "></div>
		</div>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/autosize.min.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/icheck.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.easing.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/pace.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/viewportchecker.js" type="text/javascript"></script>		
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/scripts.js" type="text/javascript"></script>  
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/perfect-scrollbar.min.js" type="text/javascript"></script>
		<script type="text/javascript">			
			function chat_ref() {
				jQuery.ajax({
					url:'<?php echo Yii::app()->createUrl('users/chat'); ?>',
					type:'POST',
					success:function(results) {
						jQuery(".contact-list").html(results);
						//setTimeout(chat_ref, 10000);
					}
				});
			}
			$('img').bind('contextmenu', function(e){
				return false;
			});
		</script>
    </body>
</html>