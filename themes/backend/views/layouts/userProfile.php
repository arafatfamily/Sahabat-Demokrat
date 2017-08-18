<div class="profile-info row">
	<div class="profile-image col-md-4 col-sm-4 col-xs-4">
		<a href="<?php echo Yii::app()->createUrl('member/view', array('id' => Yii::app()->user->getUser("kader_id"))); ?>">
			<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getUser("kader_id"))); ?>" class="img-responsive img-circle">
		</a>
	</div>
	<div class="profile-details col-md-8 col-sm-8 col-xs-8">
		<h3>
			<a href="<?php echo Yii::app()->createUrl('member/view', array('id' => Yii::app()->user->getUser("kader_id"))); ?>"><?php echo Yii::app()->user->getUser("member_name") ?></a>
			<span class="profile-status online"></span>
		</h3>
		<p class="profile-title"><?php echo Yii::app()->user->getUser("location") ?></p>
	</div>
</div>