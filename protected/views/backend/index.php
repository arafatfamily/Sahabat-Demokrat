<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">BackEnd Settings</h2>
			<div class="actions panel_actions pull-right">
			</div>
		</header><div class="clearfix"></div></br>
		<div class="row col-xs-12">
			<div class="col-xs-12">
				<ul class="nav nav-tabs vertical col-lg-3 col-md-3 col-sm-4 col-xs-4 left-aligned primary">
				<?php  if (Yii::app()->user->getAkses("44", "9") || Yii::app()->user->isSuperadmin()) {
					echo '<li class="active"><a href="#Tampilan" data-toggle="tab"><i class="fa fa-laptop"></i>Tampilan</a></li>';
				} if (Yii::app()->user->getAkses("45", "9") || Yii::app()->user->isSuperadmin()) {
					echo '<li><a href="#Menu" data-toggle="tab"><i class="fa fa-th-list"></i>Menu</a></li>';
				} if (Yii::app()->user->getAkses("46", "9") || Yii::app()->user->isSuperadmin()) {
					echo '<li><a href="#Akses" data-toggle="tab"><i class="fa fa-shield"></i>Hak Akses</a></li>';
				} ?>					
				</ul>
				<?php $this->renderPartial('view'); ?>
			</div>
		</div><div class="clearfix"></div></br>
	</section>
</div>