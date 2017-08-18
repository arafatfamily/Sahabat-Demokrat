<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.tocify.css" rel="stylesheet" type="text/css" media="screen"/>
<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active">
			<a href="#admin" data-toggle="tab">
				<i class="fa fa-book"></i> MANUAL ADMINISTRATOR
			</a>
		</li>
		<li>
			<a href="#developer" data-toggle="tab"">
				<i class="fa fa-code"></i> MANUAL PENGEMBANG
			</a>
		</li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="admin">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<?php $this->renderPartial('_admin'); ?>
			</div><div class="clearfix"></div>
		</div>
		<div class="tab-pane fade" id="developer">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<!--?php $this->renderPartial('_developer', array('model'=>$model)); ?-->
			</div><div class="clearfix"></div>
		</div>
	</div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.tocify.min.js" type="text/javascript"></script>