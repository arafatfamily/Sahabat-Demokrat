<?php
$baseUrl = Yii::app()->theme->baseUrl;
?>  
<!DOCTYPE html>
<html class=" ">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Sahabat Demokrat : Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="<?php echo $baseUrl; ?>/../backend/images/favicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl; ?>/../backend/images/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $baseUrl; ?>/../backend/images/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl; ?>/../backend/images/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl; ?>/../backend/images/apple-touch-icon-144-precomposed.png">
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/blue.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo $baseUrl; ?>/../backend/css+js/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class=" login_page">
        <div class="login-wrapper">
            <div id="login" class="login loginpage col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-0 col-xs-12">
                <h1><a href="#" title="Login Page" tabindex="-1">Sahabat Demokrat</a></h1>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'focus' => array($model, 'firstName'),
                    ),
                ));
                ?>
                <p>
                    <label for="username">Username<br />
                        <?php echo $form->textField($model, 'username', array("class" => "input")); ?>
                        <?php echo $form->error($model, 'password', array("style" => "color:red;font-weight:bold;")); ?>

                    </label>
                </p>
                <p>
                    <label for="password">Password<br />
                        <?php echo $form->passwordField($model, 'password', array("class" => "input")); ?>
                        <?php echo $form->error($model, 'password', array("style" => "color:red;font-weight:bold;")); ?> 

                    </label>
                </p>
                <!--p class="forgetmenot">
                    <label class="icheck-label form-label" for="rememberme">
                        <?php echo $form->checkBox($model, 'rememberMe', array("class" => "skin-square-info")); ?>
                        Remember me</label>
                </p-->
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-success btn-block')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/pace.min.js" type="text/javascript"></script>  
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/viewportchecker.js" type="text/javascript"></script>  
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/icheck.min.js" type="text/javascript"></script>
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/scripts.js" type="text/javascript"></script> 
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo $baseUrl; ?>/../backend/css+js/chart-sparkline.js" type="text/javascript"></script>
    </body>
</html>



